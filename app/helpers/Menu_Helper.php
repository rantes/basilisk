<?php
/**
 * @author rantes
 */
class menuEntry {
    public $link = '';
    public $label = '';
    public $items = [];
    public $icon = '';
    public $target = '_self';
    public $hasItems = false;
/**
 *
 * @param string $link
 * @param string $label
 * @param array $items
 * @param string $icon
 * @param string $target
 */
    public function __construct($link, $label, $items = [], $icon = '', $target = '_self') {
        $this->link = $link;
        $this->label = $label;
        $this->items = $items;
        $this->icon = $icon;
        $this->target = $target;

        $this->hasItems = !empty($this->items);
    }
}


function adminMenu() {
    return [
        new menuEntry('/admin/index', 'Inicio', null, 'home'),
        new menuEntry('/admin/users', 'Usuarios', null, 'user'),
        new menuEntry('/admin/logout?logout=1', 'Salir', null, 'exit')
    ];
}