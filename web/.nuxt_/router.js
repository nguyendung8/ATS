import Vue from 'vue'
import Router from 'vue-router'
import { normalizeURL, decode } from 'ufo'
import { interopDefault } from './utils'
import scrollBehavior from './router.scrollBehavior.js'

const _3c25fc02 = () => interopDefault(import('..\\pages\\assessment-forms\\index.vue' /* webpackChunkName: "pages/assessment-forms/index" */))
const _19b405ce = () => interopDefault(import('..\\pages\\ats\\index.vue' /* webpackChunkName: "pages/ats/index" */))
const _2fc3ade8 = () => interopDefault(import('..\\pages\\calendar\\index.vue' /* webpackChunkName: "pages/calendar/index" */))
const _73a1df96 = () => interopDefault(import('..\\pages\\candidates\\index.vue' /* webpackChunkName: "pages/candidates/index" */))
const _7bf53b34 = () => interopDefault(import('..\\pages\\index.vue' /* webpackChunkName: "pages/index" */))
const _26cb8bd0 = () => interopDefault(import('..\\pages\\jobs\\index.vue' /* webpackChunkName: "pages/jobs/index" */))
const _e8a5f506 = () => interopDefault(import('..\\pages\\login.vue' /* webpackChunkName: "pages/login" */))
const _32ff1d2c = () => interopDefault(import('..\\pages\\permissions\\index.vue' /* webpackChunkName: "pages/permissions/index" */))
const _f2d37a86 = () => interopDefault(import('..\\pages\\pipelines\\index.vue' /* webpackChunkName: "pages/pipelines/index" */))
const _0e8e0a91 = () => interopDefault(import('..\\pages\\stages\\index.vue' /* webpackChunkName: "pages/stages/index" */))
const _704dcefc = () => interopDefault(import('..\\pages\\assessment-forms\\create.vue' /* webpackChunkName: "pages/assessment-forms/create" */))
const _e36b454e = () => interopDefault(import('..\\pages\\ats\\about\\index.vue' /* webpackChunkName: "pages/ats/about/index" */))
const _502e55fb = () => interopDefault(import('..\\pages\\ats\\cv\\index.vue' /* webpackChunkName: "pages/ats/cv/index" */))
const _32d02a1c = () => interopDefault(import('..\\pages\\ats\\history\\index.vue' /* webpackChunkName: "pages/ats/history/index" */))
const _cd87fd90 = () => interopDefault(import('..\\pages\\ats\\jobs\\index.vue' /* webpackChunkName: "pages/ats/jobs/index" */))
const _0968c709 = () => interopDefault(import('..\\pages\\auth\\callback.vue' /* webpackChunkName: "pages/auth/callback" */))
const _4b4b8e24 = () => interopDefault(import('..\\pages\\jobs\\create.vue' /* webpackChunkName: "pages/jobs/create" */))
const _73e65fa1 = () => interopDefault(import('..\\pages\\pipelines\\create.vue' /* webpackChunkName: "pages/pipelines/create" */))
const _ecde1c74 = () => interopDefault(import('..\\pages\\ats\\my-profile\\edit.vue' /* webpackChunkName: "pages/ats/my-profile/edit" */))
const _37c8f1a0 = () => interopDefault(import('..\\pages\\ats\\jobs\\_id.vue' /* webpackChunkName: "pages/ats/jobs/_id" */))
const _f674a926 = () => interopDefault(import('..\\pages\\ats\\cv\\_id\\edit.vue' /* webpackChunkName: "pages/ats/cv/_id/edit" */))
const _3280bb44 = () => interopDefault(import('..\\pages\\candidates\\_id\\index.vue' /* webpackChunkName: "pages/candidates/_id/index" */))
const _73dd89f4 = () => interopDefault(import('..\\pages\\interviews\\_id\\index.vue' /* webpackChunkName: "pages/interviews/_id/index" */))
const _1eeb13a7 = () => interopDefault(import('..\\pages\\meeting\\_id\\index.vue' /* webpackChunkName: "pages/meeting/_id/index" */))
const _7e461418 = () => interopDefault(import('..\\pages\\assessment-forms\\_id\\edit.vue' /* webpackChunkName: "pages/assessment-forms/_id/edit" */))
const _890c227c = () => interopDefault(import('..\\pages\\jobs\\_id\\edit.vue' /* webpackChunkName: "pages/jobs/_id/edit" */))
const _3805672f = () => interopDefault(import('..\\pages\\pipelines\\_id\\edit.vue' /* webpackChunkName: "pages/pipelines/_id/edit" */))

const emptyFn = () => {}

Vue.use(Router)

export const routerOptions = {
  mode: 'history',
  base: '/',
  linkActiveClass: 'nuxt-link-active',
  linkExactActiveClass: 'nuxt-link-exact-active',
  scrollBehavior,

  routes: [{
    path: "/assessment-forms",
    component: _3c25fc02,
    name: "assessment-forms___vi"
  }, {
    path: "/ats",
    component: _19b405ce,
    name: "ats___vi"
  }, {
    path: "/calendar",
    component: _2fc3ade8,
    name: "calendar___vi"
  }, {
    path: "/candidates",
    component: _73a1df96,
    name: "candidates___vi"
  }, {
    path: "/en",
    component: _7bf53b34,
    name: "index___en"
  }, {
    path: "/jobs",
    component: _26cb8bd0,
    name: "jobs___vi"
  }, {
    path: "/login",
    component: _e8a5f506,
    name: "login___vi"
  }, {
    path: "/permissions",
    component: _32ff1d2c,
    name: "permissions___vi"
  }, {
    path: "/pipelines",
    component: _f2d37a86,
    name: "pipelines___vi"
  }, {
    path: "/stages",
    component: _0e8e0a91,
    name: "stages___vi"
  }, {
    path: "/assessment-forms/create",
    component: _704dcefc,
    name: "assessment-forms-create___vi"
  }, {
    path: "/ats/about",
    component: _e36b454e,
    name: "ats-about___vi"
  }, {
    path: "/ats/cv",
    component: _502e55fb,
    name: "ats-cv___vi"
  }, {
    path: "/ats/history",
    component: _32d02a1c,
    name: "ats-history___vi"
  }, {
    path: "/ats/jobs",
    component: _cd87fd90,
    name: "ats-jobs___vi"
  }, {
    path: "/auth/callback",
    component: _0968c709,
    name: "auth-callback___vi"
  }, {
    path: "/en/assessment-forms",
    component: _3c25fc02,
    name: "assessment-forms___en"
  }, {
    path: "/en/ats",
    component: _19b405ce,
    name: "ats___en"
  }, {
    path: "/en/calendar",
    component: _2fc3ade8,
    name: "calendar___en"
  }, {
    path: "/en/candidates",
    component: _73a1df96,
    name: "candidates___en"
  }, {
    path: "/en/jobs",
    component: _26cb8bd0,
    name: "jobs___en"
  }, {
    path: "/en/login",
    component: _e8a5f506,
    name: "login___en"
  }, {
    path: "/en/permissions",
    component: _32ff1d2c,
    name: "permissions___en"
  }, {
    path: "/en/pipelines",
    component: _f2d37a86,
    name: "pipelines___en"
  }, {
    path: "/en/stages",
    component: _0e8e0a91,
    name: "stages___en"
  }, {
    path: "/jobs/create",
    component: _4b4b8e24,
    name: "jobs-create___vi"
  }, {
    path: "/pipelines/create",
    component: _73e65fa1,
    name: "pipelines-create___vi"
  }, {
    path: "/ats/my-profile/edit",
    component: _ecde1c74,
    name: "ats-my-profile-edit___vi"
  }, {
    path: "/en/assessment-forms/create",
    component: _704dcefc,
    name: "assessment-forms-create___en"
  }, {
    path: "/en/ats/about",
    component: _e36b454e,
    name: "ats-about___en"
  }, {
    path: "/en/ats/cv",
    component: _502e55fb,
    name: "ats-cv___en"
  }, {
    path: "/en/ats/history",
    component: _32d02a1c,
    name: "ats-history___en"
  }, {
    path: "/en/ats/jobs",
    component: _cd87fd90,
    name: "ats-jobs___en"
  }, {
    path: "/en/auth/callback",
    component: _0968c709,
    name: "auth-callback___en"
  }, {
    path: "/en/jobs/create",
    component: _4b4b8e24,
    name: "jobs-create___en"
  }, {
    path: "/en/pipelines/create",
    component: _73e65fa1,
    name: "pipelines-create___en"
  }, {
    path: "/en/ats/my-profile/edit",
    component: _ecde1c74,
    name: "ats-my-profile-edit___en"
  }, {
    path: "/en/ats/jobs/:id",
    component: _37c8f1a0,
    name: "ats-jobs-id___en"
  }, {
    path: "/en/ats/cv/:id/edit",
    component: _f674a926,
    name: "ats-cv-id-edit___en"
  }, {
    path: "/ats/jobs/:id",
    component: _37c8f1a0,
    name: "ats-jobs-id___vi"
  }, {
    path: "/en/candidates/:id",
    component: _3280bb44,
    name: "candidates-id___en"
  }, {
    path: "/en/interviews/:id",
    component: _73dd89f4,
    name: "interviews-id___en"
  }, {
    path: "/en/meeting/:id",
    component: _1eeb13a7,
    name: "meeting-id___en"
  }, {
    path: "/ats/cv/:id/edit",
    component: _f674a926,
    name: "ats-cv-id-edit___vi"
  }, {
    path: "/en/assessment-forms/:id?/edit",
    component: _7e461418,
    name: "assessment-forms-id-edit___en"
  }, {
    path: "/en/jobs/:id/edit",
    component: _890c227c,
    name: "jobs-id-edit___en"
  }, {
    path: "/en/pipelines/:id/edit",
    component: _3805672f,
    name: "pipelines-id-edit___en"
  }, {
    path: "/candidates/:id",
    component: _3280bb44,
    name: "candidates-id___vi"
  }, {
    path: "/interviews/:id",
    component: _73dd89f4,
    name: "interviews-id___vi"
  }, {
    path: "/meeting/:id",
    component: _1eeb13a7,
    name: "meeting-id___vi"
  }, {
    path: "/assessment-forms/:id?/edit",
    component: _7e461418,
    name: "assessment-forms-id-edit___vi"
  }, {
    path: "/jobs/:id/edit",
    component: _890c227c,
    name: "jobs-id-edit___vi"
  }, {
    path: "/pipelines/:id/edit",
    component: _3805672f,
    name: "pipelines-id-edit___vi"
  }, {
    path: "/",
    component: _7bf53b34,
    name: "index___vi"
  }],

  fallback: false
}

export function createRouter (ssrContext, config) {
  const base = (config._app && config._app.basePath) || routerOptions.base
  const router = new Router({ ...routerOptions, base  })

  // TODO: remove in Nuxt 3
  const originalPush = router.push
  router.push = function push (location, onComplete = emptyFn, onAbort) {
    return originalPush.call(this, location, onComplete, onAbort)
  }

  const resolve = router.resolve.bind(router)
  router.resolve = (to, current, append) => {
    if (typeof to === 'string') {
      to = normalizeURL(to)
    }
    return resolve(to, current, append)
  }

  return router
}
