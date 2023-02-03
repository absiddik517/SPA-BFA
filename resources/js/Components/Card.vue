<template>
  <div class="card" :class="varientClass" style="overflow: hidden;">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div class="card-title flex-1">
        <slot name="title">CARD TITLE</slot>
      </div>
      <div class="card-tools flex-1 text-right">
        <slot name="title_right"></slot>
      </div>
    </div>
    <div class="card-body" :class="bodyClass">
      <slot></slot>
    </div>
  </div>
</template>

<script setup>
  import { ref, onMounted } from 'vue'
  const props = defineProps({
    isTable: {
      type: Boolean,
      default: false
    },
    varient: {
      type: String,
      default: 'light'
    },
  })
  
  const varientClass = ref('');
  const bodyClass = ref('');
  
  onMounted(() => {
    varientClass.value = `card-${props.varient}`
    bodyClass.value = props.isTable ? 'table-responsive p-0' : ''
  })
  
</script>