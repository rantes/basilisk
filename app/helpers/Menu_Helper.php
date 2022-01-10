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
        new menuEntry('/admin/users', 'Usuarios', null, 'users'),
        new menuEntry('/admin/translations', _('admin.menu.label.translations'), null, 'g_translate'),
        new menuEntry('/admin/profile', _('admin.menu.label.profile'), null, 'profile'),
        new menuEntry('/index/logout?logout=1', 'Salir', null, 'exit')
    ];
}

function generalMenu() {
    return [
        new menuEntry('/index/index', 'Inicio', null, 'home'),
        new menuEntry('/admin/users', 'Usuarios', null, 'user'),
        new menuEntry('/index/logout?logout=1', 'Salir', null, 'exit')
    ];
}
