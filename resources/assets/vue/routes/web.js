import Index from '../pages/Index';

const Dashboard = () => import('~/pages/Dashboard').then(m => m.default || m);
const OrderIndex = () => import('~/pages/Orders/Index').then(m => m.default || m);
const OrderGrouped = () => import('~/pages/Orders/Grouped').then(m => m.default || m);
const OrderEdit = () => import('~/pages/Orders/Edit').then(m => m.default || m);
const ProductIndex = () => import('~/pages/Products/Index').then(m => m.default || m);

export default [
    {
        path: '/', component: Index, meta: {icon: 'mdi mdi-view-dashboard', title: 'Консоль'}, children: [
            {name: 'home', path: '', component: Dashboard, meta: {title: 'Главная'}}
        ]
    }, {
        path: '/orders', component: Index, meta: {icon: 'mdi mdi-camera-party-mode', title: 'Заказы'}, children: [
            {name: 'orders.index', path: '', component: OrderIndex, meta: {title: 'Список заказов', btn_name: 'Все'}},
            {name: 'orders.grouped', path: 'grouped', component: OrderGrouped, meta: {title: 'Сгрупперованный список заказов', btn_name: 'Сгрупперованные'}},
            {name: 'orders.create', path: 'create', component: OrderIndex, meta: {title: 'Создать', btn_name: 'Создать'}},
            {name: 'orders.edit', path: 'edit/:id', component: OrderEdit, meta: {title: 'Редактирование заказа', is_show: false}}
        ]
    },
    {
        path: '/products', component: Index, meta: {icon: 'mdi mdi-google-pages', title: 'Продукты'}, children: [
            {name: 'products', path: '', component: ProductIndex, meta: {title: 'Список продуктов', btn_name: 'Все'}},
            {name: 'products.create', path: 'create', component: ProductIndex, meta: {title: 'Создать продукт', btn_name: 'Создать'}}
        ]
    }
];
