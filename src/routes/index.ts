/**
 * Internal dependencies
 */
import HomePage from '../pages/HomePage';
import OptionsPage from '../pages/options/OptionsPage';
import OrdersPage from '../pages/orders/OrdersPage';
import CreateOrder from '../pages/orders/CreateOrder';
import EditOrder from '../pages/orders/EditOrder';

const routes = [
    {
        path: '/',
        element: HomePage,
    },
    {
        path: '/options',
        element: OptionsPage,
    },
    {
        path: '/orders',
        element: OrdersPage,
    },
    {
        path: '/orders/new',
        element: CreateOrder,
    },
    {
        path: '/orders/edit/:id',
        element: EditOrder,
    },
];

export default routes;
