<template>
  <footer
    class="border-t-[1px] border-black mx-2 mt-12 pt-3 text-sm sm:text-sm md:text-sm lg:text-base"
  >
    Root name: {{ $router.currentRoute.value.name }} &mdash; Path:
    {{ $router.currentRoute.value.path }} &mdash; Params:
    {{ $router.currentRoute.value.params }}
  </footer>
</template>
