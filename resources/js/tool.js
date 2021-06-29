Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'nova-gatekeeper',
      path: '/nova-gatekeeper',
      component: require('./components/Tool'),
    },
  ])
})
