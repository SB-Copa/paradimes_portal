<script setup></script>

<template>
  <!-- <h1>You did it!</h1>
  <p class="text-lg">
    Visit <a href="https://vuejs.org/" target="_blank" rel="noopener">vuejs.org</a> to read the
    documentation
  </p> -->
  <v-app class="tw:h-full tw:w-full">
    <v-main  class="tw:h-full tw:w-full">
        <router-view></router-view>
    </v-main>
  </v-app>
</template>

<style scoped>
</style>
