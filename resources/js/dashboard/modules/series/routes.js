export default [{
  path: 'series',
  component: () => import('js/App.vue'),
  children: [{
    path: '/',
    name: 'dashboard.series',
    component: () => import('./Series')
  }, {
    path: 'create',
    name: 'dashboard.series.create',
    component: () => import('./Create')
  }, {
    path: ':id/edit',
    name: 'dashboard.article.edit',
    component: () => import('./Edit')
  }]
}]
