import Index from '../pages/Index';

const Dashboard = () => import('~/pages/Dashboard').then(m => m.default || m);

export default [
    {
        path: '/', component: Index, children: [
            {name: 'home', path: '', component: Dashboard, meta: {title: 'Главная'}}
        ]
    }
];
