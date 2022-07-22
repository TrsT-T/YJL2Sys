/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-04 15:33:57
 * @LastEditTime: 2022-07-04 16:25:44
 * @Description: 
 */
import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)
    /* Layout */
import Layout from '@/layout'
/**
 * constantRoutes
 * a base page that does not have permission requirements
 * all roles can be accessed
 */
export const constantRoutes = [{
            path: '/redirect',
            component: Layout,
            hidden: true,
            children: [{
                path: '/redirect/:path(.*)',
                component: () =>
                    import ('@/views/redirect/index')
            }]
        },
        {
            path: '/login',
            component: () =>
                import ('@/views/public/login/index'),
            hidden: true
        },
        {
            path: '/',
            component: Layout,
            hidden: true,
            redirect: '/index',
            children: [{
                path: 'index',
                component: () =>
                    import ('@/views/public/index/index'),
                hidden: true
            }]
        },
        {
            path: '/404',
            component: () =>
                import ('@/views/error-page/404'),
            hidden: true
        }

    ]
    /**
     * asyncRoutes
     * the routes that need to be dynamically loaded based on user roles
     */
export const asyncRoutes = [

]
const createRouter = () => new Router({
    // mode: 'history', // require service support
    scrollBehavior: () => ({ y: 0 }),
    routes: constantRoutes
})

const router = createRouter()

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
    const newRouter = createRouter()
    router.matcher = newRouter.matcher // reset router
}

export default router