<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
    <img alt="Vue logo" class="logo" src="@/assets/logo.svg" width="25" height="25" />
      <nav>
        <RouterLink to="/">Home</RouterLink>
        <RouterLink to="/about">About</RouterLink>
      </nav>
  <RouterView />
</template>

