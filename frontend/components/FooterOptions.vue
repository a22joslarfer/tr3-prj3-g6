<template>
  <div class="footer">
    <div class="icon">
      <nuxt-link to="/" @click="highlightActive('/')" :class="{ active: isActive('/') }">
        <svg xmlns="http://www.w3.org/2000/svg" height="27" viewBox="0 -960 960 960" width="27">
          <path d="M231.5-201v-353.5L153-497l-12-14 339-248.5L665.5-623v-88H725v131.5l95 68.5-11.5 14-78.5-57.5V-201H566v-196H394v196H231.5ZM419-552.5h122q0-24.5-17.75-42.25T480-612.5q-25.5 0-43.25 17.661T419-552.5Z" />
        </svg>
      </nuxt-link>
    </div>
    <div class="icon">
      <nuxt-link to="/inTimes" @click="highlightActive('/inTimes')" :class="{ active: isActive('/inTimes') }">
        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
          <path d="M120-520v-320h320v320H120Zm0 400v-320h320v320H120Zm400-400v-320h320v320H520Zm0 400v-320h320v320H520ZM200-600h160v-160H200v160Zm400 0h160v-160H600v160Zm0 400h160v-160H600v160Zm-400 0h160v-160H200v160Zm400-400Zm0 240Zm-240 0Zm0-240Z"/>
        </svg>
      </nuxt-link>
    </div>
    <div class="icon">
      <nuxt-link to="/" @click="highlightActive('/')">
        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
          <path d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z"/>
        </svg>
      </nuxt-link>
    </div>
    <div class="icon">
      <nuxt-link to="/PERFIL/main" @click="highlightActive('/PERFIL/main')" :class="{ active: isActive('/PERFIL/main') }">
        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
          <path d="M235.196-279.587q51-38.522 113.521-60.543Q411.239-362.152 480-362.152t131.641 22.38q62.881 22.381 113.163 60.424 34.283-41.239 53.305-91.924Q797.13-421.957 797.13-480q0-131.565-92.782-224.348Q611.565-797.13 480-797.13t-224.348 92.782Q162.87-611.565 162.87-480q0 57.804 18.902 108.489t53.424 91.924ZM480-437.848q-59.957 0-100.935-40.858-40.978-40.859-40.978-100.816 0-59.956 40.978-100.935Q420.043-721.435 480-721.435t100.935 40.978q40.978 40.979 40.978 100.935 0 59.957-40.978 100.816Q539.957-437.848 480-437.848Zm0 365.979q-84.674 0-159.109-32.098t-129.63-87.294q-55.196-55.195-87.294-129.63T71.869-480q0-84.674 32.098-159.109t87.294-129.63q55.195-55.196 129.63-87.294T480-888.131q84.674 0 159.109 32.098t129.63 87.294q55.196 55.195 87.294 129.63T888.131-480q0 84.674-32.098 159.109t-87.294 129.63q-55.195 55.196-129.63 87.294T480-71.869Z"/>
        </svg>
      </nuxt-link>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    isActive(route) {
      return this.$route.path === route;
    },
    highlightActive(route) {
      if (!this.isActive(route)) {
        this.$router.push(route);
      }
    }
  }
}
</script>

<style scoped>
.footer {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  display: flex;
  justify-content: space-around;
  align-items: center;
  background-color: #ffffff;
  color: white;
  min-height: 60px; 
  box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2);
  z-index: 1001;
}

.icon {
  cursor: pointer;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.icon svg {
  fill: rgb(0, 0, 0);
}

.icon span {
  font-size: 12px;
}

svg {
  fill: rgb(0, 0, 0);
}

.active svg {
  fill: rgb(26, 29, 211);
}
</style>
