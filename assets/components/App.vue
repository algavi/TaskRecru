<template>
  <div>
    <h1>{{ message }}</h1>
  </div>
</template>

<script>
export default {
  data() {
    return {
      message: "Vue je propojen se Symfony!"
    };
  }
};
console.log("Vue aplikace je připojena!");

</script>



<style scoped>
h1 {
  color: #42b983;
}
</style>