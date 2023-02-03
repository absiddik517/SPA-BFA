<template>
  <Multiselect
    :model-value="modelValue"
    :placeholder="placeholder"
    :close-on-select="true"
    :id="id"
    :searchable="searchable"
    :object="object"
    :options="data"
    :disabled="disabled"
    @search-change="fetchLanguages"
    :loading="isFatching"
    @change="handelSelect"
  >
    <template v-slot:singlelabel="{ value }">
      <div class="multiselect-single-label">
        <img v-show="value.img" class="character-label-icon" :src="value.img"> 
        {{ value.label }}
      </div>
    </template>
  
    <template v-slot:option="{ option }">
      <img v-show="option.img" class="character-option-icon" :src="option.img"> 
      <div class="flex-1 d-flex justify-content-between">
        <span>{{ option.label }}</span>
        <span v-show="include" class="text-muted">{{ option[include] }}</span>
      </div>
    </template>
  </Multiselect>
</template>

<script>
  import Multiselect from '@vueform/multiselect'
  import axios from 'axios'

  export default {
    components: {
      Multiselect,
    },
    props: {
      modelValue: [String, Number, Object],
      include: {
        type: String,
        default: null
      },
      searchable: {
        type: Boolean,
        default: true
      },
      object: { type: Boolean, default: false },
      disabled: { type: Boolean, default: false },
      placeholder: {
        type: String,
        default: 'Select one'
      },
      options: {
        type: Array,
        default: []
      },
      from: { type: String, default: null },
      id: { type: String, default: null },
      imgKey: { type: String, default: null },
      trackBy: { type: String, default: 'value' },
      label: { type: String, default: 'label' },
      additional: { type: Array, default: [] },
      
    },
    data() {
      return {
        value: [],
        records: [],
        isFatching: false
      }
    },
    computed:{
      data() {
        if(this.from) return this.records
        return this.options
      }
    },
    mounted(){
      this.fetchLanguages('');
    },
    methods: {
      async fetchLanguages(query){
        if(!this.from) return
        this.isFatching = true
        console.log('getting data query = '+query)
        await axios.get(`${this.route(this.from)}?name=${query}`)
        .then(response => {
          this.records = this.prepare(response.data);
          console.log(response.data)
          console.log(this.records)
        });
        this.isFatching = false
      },
      
      prepare(result){
        let response = result.map(item => {
          let obj = {
            label: item[this.label],
            value: item[this.trackBy]
          }
          if(this.imgKey) obj.img = item[this.imgKey]
          this.additional.forEach(field => {
            if(item[field]) obj[field] = item[field]
          })
          return obj
        })
        return response
      },
      
      handelSelect(value){
        this.$emit('update:modelValue', value)
      }
      
    }
  }
</script>

<style lang="scss" scoped>
  @import "@vueform/multiselect/themes/default.css";
  img{
    width: 22px;
    border-radius: 50%;
    margin-right: 6px;
  }
</style>