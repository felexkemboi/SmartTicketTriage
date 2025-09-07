<template>
  <div>
    <div class="topbar">
      <router-link 
        to="/" 
        class="tab" 
        :class="{ active: $route.path === '/' }"
      >
        Tickets
      </router-link>

      <router-link 
          to="/dashboard" 
          class="tab" 
          :class="{ active: $route.path === '/dashboard' }"
        >
        Dashboard
      </router-link>
    </div>

    <router-view />
  </div>
</template>
