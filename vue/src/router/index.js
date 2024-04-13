import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/page/HomeView.vue'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'page.home',
      component: HomeView,
      meta: { auth: false }
    },
    {
      path: '/o-firmie',
      name: 'page.about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/page/AboutView.vue'),
      meta: { auth: false }
    },
    {
      path: '/admin/products/brands',
      name: 'admin.product.brand.index',
      component: () => import('../views/admin/product/brand/IndexView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/brands/create',
      name: 'admin.product.brand.create',
      component: () => import('../views/admin/product/brand/CreateView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/brands/show/:id',
      name: 'admin.product.brand.show',
      component: () => import('../views/admin/product/brand/ShowView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/brands/:id/edit',
      name: 'admin.product.brand.edit',
      component: () => import('../views/admin/product/brand/EditView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/categories',
      name: 'admin.product.category.index',
      component: () => import('../views/admin/product/category/IndexView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/categories/create',
      name: 'admin.product.category.create',
      component: () => import('../views/admin/product/category/CreateView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/categories/show/:id',
      name: 'admin.product.category.show',
      component: () => import('../views/admin/product/category/ShowView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/categories/:id/edit',
      name: 'admin.product.category.edit',
      component: () => import('../views/admin/product/category/EditView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/conditions',
      name: 'admin.product.condition.index',
      component: () => import('../views/admin/product/condition/IndexView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/conditions/create',
      name: 'admin.product.condition.create',
      component: () => import('../views/admin/product/condition/CreateView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/conditions/show/:id',
      name: 'admin.product.condition.show',
      component: () => import('../views/admin/product/condition/ShowView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/conditions/:id/edit',
      name: 'admin.product.condition.edit',
      component: () => import('../views/admin/product/condition/EditView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/products',
      name: 'admin.product.product.index',
      component: () => import('../views/admin/product/product/IndexView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/products/create',
      name: 'admin.product.product.create',
      component: () => import('../views/admin/product/product/CreateView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/products/show/:id',
      name: 'admin.product.product.show',
      component: () => import('../views/admin/product/product/ShowView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/products/:id/edit',
      name: 'admin.product.product.edit',
      component: () => import('../views/admin/product/product/EditView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/:id/types',
      name: 'admin.product.type.index',
      component: () => import('../views/admin/product/product/type/IndexView.vue'),
      meta: { auth: true }
    },
    {
      path: '/admin/products/:product_id/types/show/:id',
      name: 'admin.product.type.show',
      component: () => import('../views/admin/product/product/type/ShowView.vue'),
      meta: { auth: true }
    },
    {
      path: '/zaloguj',
      name: 'login',
      component: () => import('../views/auth/LoginView.vue'),
      meta: { auth: false }
    },
    {
      path: '/wyloguj',
      name: 'logout',
      component: () => import('../views/auth/LogoutView.vue'),
      meta: { auth: true }
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: () => import('../views/error/NotFoundView.vue'),
      meta: { auth: false }
    }
  ]
})

router.beforeEach((to) => {
  const store = useAuthStore()

  if (to.meta.auth === true && store.isGuest && to.name !== 'login') {
    return { name: 'login' }
  }
})

export default router
