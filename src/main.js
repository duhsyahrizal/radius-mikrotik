var url = window.location;

$('ul.nav-sidebar a').filter(function() {
    return this.href == url;
}).addClass('active');

$('ul.nav-treeview a').filter(function() {
    return this.href == url;
}).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');