import Home from "./components/Home";
import Summary from "./components/cafe/Summary";
import NotFound from "./components/NotFound";

export default  {

    mode: 'history',

    routes: [
        {
            path: '*',
            component: NotFound
        },
        {
            path: '/',
            component: Home
        },
        {
            path: '/cafe',
            component: Summary
        }
    ]
}
