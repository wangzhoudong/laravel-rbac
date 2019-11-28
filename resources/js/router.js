import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

const routes = [
    {
        path: '/login',
        name: 'login',
        component: require('./pages/login/index').default,
        meta: {
            title: '登录'
        }
    },
    {
        path: '*',
        redirect: '/dashboard'
    }, {
        path: '/dashboard',
        name: 'dashboard',
        component: require('./pages/dashboard').default,
        meta: {
            title: '欢迎页面'
        }
    },
    {
        path: '/user',
        name: 'user',
        component: require('./pages/user/index').default,
        meta: {
            title: '用户管理'
        }
    },
    {
        path: '/role',
        name: 'role',
        component: require('./pages/role/index').default,
        meta: {
            title: '角色管理'
        }
    },
    {
        path: '/menu',
        name: 'menu',
        component: require('./pages/menu/index').default,
        meta: {
            title: '菜单管理'
        }
    },
    {
        path: '/api',
        name: 'api',
        component: require('./pages/api/index').default,
        meta: {
            title: 'API管理'
        }
    }

];

const router = new Router({ mode: 'history',
        routes,
        base: '/' + window.basePath + '/'
});

router.beforeEach((to, from, next) => {

    const title = to.meta && to.meta.title;
    if (title) {
        document.title = title;
    }
    next();
});

export {
    router
};
