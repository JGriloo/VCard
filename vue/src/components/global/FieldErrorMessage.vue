<<<<<<< HEAD
<template>
  <div
    v-if="errors ? errors[fieldName] : false"
    class="validation-error"
  >
    {{ errors[fieldName][0] || '' }}
  </div>
</template>

<script>
export default {
  name: "FieldErrorMessage",
  props: {
    errors: {
      type: Object,
      default: null,
    },
    fieldName: {
      type: String,
      default: "",
    },
  },
};
</script>

<style scoped>
.validation-error {
  color: red;
  font-size: 0.85rem;
}
=======
<template>
  <div
    v-if="errors ? errors[fieldName] : false"
    class="validation-error"
  >
    {{ errors[fieldName][0] || '' }}
  </div>
</template>

<script>
export default {
  name: "FieldErrorMessage",
  props: {
    errors: {
      type: Object,
      default: null,
    },
    fieldName: {
      type: String,
      default: "",
    },
  },
};
</script>

<style scoped>
.validation-error {
  color: red;
  font-size: 0.85rem;
}
>>>>>>> 2b051026b75e280f09607fa3e9db532d3067424a
</style>