<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\MenusRepository;
use Illuminate\Http\Request;
use Menu;

class SiteController extends Controller
{
    protected $p_rep;  //репозиторий портфолио
    protected $s_rep;  //репозиторий слайдера
    protected $a_rep;  //репозиторий статей
    protected $m_rep;  //репозиторий меню

    protected $template;
    protected $vars = array(); //массив передаваемых в шаблон переменных
    protected $bar = false; // наличие сайдбара
    protected $contentRightBar = false; //содержимое правого сайдбара
    protected $contentLeftBar = false;  //содержимое левого сайдбара

    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    /*
     * метод, возвращающий сгенерированный шаблон
     */
    protected function renderOutput()
    {
        $menu = $this->getMenu();
        //dd($menu);
        $navigation = view(env('THEME') . '.navigation')->with('menu', $menu)->render();

        $this->vars = array_add($this->vars, 'navigation', $navigation);
        return view($this->template)->with($this->vars);
    }

    protected function getMenu()
    {
        $menu = $this->m_rep->get();

        $mBuilder = Menu::make('MyNav', function($m) use ($menu) {
            foreach ($menu as $item) {
                if ($item->parent_id == 0) {
                    $m->add($item->title, $item->path)->id($item->id);
                } else {
                    if ($m->find($item->parent_id)) {
                        $m->find($item->parent_id)->add($item->title, $item->path)->id($item->id);
                    }
                }
            }
        });

        return $mBuilder;
    }
}
