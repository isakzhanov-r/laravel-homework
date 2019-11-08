import Index from '../pages/Index';

const Dashboard = () => import('~/pages/Dashboard').then(m => m.default || m);
const OrderIndex = () => import('~/pages/Orders/Index').then(m => m.default || m);
const OrderEdit = () => import('~/pages/Orders/Edit').then(m => m.default || m);

export default [
    {
        path: '/', component: Index, children: [
            {name: 'home', path: '', component: Dashboard, meta: {title: 'Главная'}},
        ],
    },{
        path:'/orders', component: Index, children: [
            {name: 'orders', path: '', component: OrderIndex, meta: {title: 'Заказы'}},
            {name: 'orders.edit', path: '/edit/:id', component: OrderEdit, meta: {title: 'Редактирование заказа'}},
        ]
    }
];
