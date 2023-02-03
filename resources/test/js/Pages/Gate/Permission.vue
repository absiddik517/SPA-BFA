<template>
  <Content>
    <div class="row">
      <div class="col-12">
        <Card :isTable="true" varient="gray">
          <template #title> Permission <i v-show="loadingTable" class="fa fa-spinner fa-spin"></i>
          </template>
          <template #title_right>
            <Button class="mr-2" type="button" varient="light" @click="showModal(null)">
              Create
            </Button>
          </template>
          <div class="row p-2 gy-2">
            <div class="col-6">
              <input v-model="filter.search" type="text" placeholder="Search..." class="form-control" />
              <i v-show="filter.search" @click="filter.search = null" class="fa fa-times filter-close" style="right: 15px;"></i>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
              Show
              <select v-model="filter.per_page" class="ml-2 select_per_page" id="per_page">
                <option disabled value="null">🔻</option>
                <option v-for="index in 100" :value="index * 5">{{ index * 5 }}</option>
                <option value="all">All</option>
              </select>
              <Dropdown animate stay header="Filter" id="filterpermissionDropdown">
                <template #btn>
                  <i class="fa fa-filter"></i>
                </template>
                
                <div class="px-2 py-1">
                  <Dropdown animate stay header="Toggle Collumn" id="filterColumnToggle">
                    <template #btn>
                      <i class="fa fa-eye"></i>  Collumn visibility
                    </template>
                    
                    <label :for="field + 'dropdown'" class="dropdown-item" v-for="(value, field) in columns">
                      <input v-model="columns[field]" type="checkbox" :id="field + 'dropdown'"> 
                      {{ field.replace('_', ' ').toUpperCase() }}
                    </label>
                  </Dropdown>
                </div>
              </Dropdown>
            </div>
          </div>

          <table class="table table-hover y-middle">
            <div v-show="loadingTable" class="overlays">
              <span>Loading... <i class="fa fa-spin fa-spinner"></i></span>
            </div>
            <thead class="bg-gray-1">
              <tr>
                <th v-show="columns.id">
                  <Filterth
                    field="id"
                    searchable
                    sortable
                    :label-click="
                      function () {
                        filter.id.isActive = true;
                        filter.search = null;
                      }
                    "
                    :close-search-fn="
                      function () {
                        filter.id.isActive = false;
                        filter.id.value = null;
                      }
                    "
                    :filter="filter"
                    :set-order="setOrder"
                    @input="
                      (value) => {
                        if (typeof value == 'string') filter.id.value = value;
                      }
                    "
                  />
                </th>
                <th v-show="columns.name">                  
                  <Filterth
                    field="name"
                    label="Name"
                    searchable
                    sortable
                    @input="
                      (value) => {
                        if (typeof value == 'string') filter.name.value = value;
                      }
                    "
                    :label-click="
                      function () {
                        filter.name.isActive = true;
                        filter.search = null;
                      }
                    "
                    :close-search-fn="
                      function () {
                        filter.name.isActive = false;
                        filter.name.value = null;
                      }
                    "
                    :filter="filter"
                    :set-order="setOrder"
                  />
                </th>
<th v-show="columns.guard_name">                  
                  <Filterth
                    field="guard_name"
                    label="Guard Name"
                    searchable
                    sortable
                    @input="
                      (value) => {
                        if (typeof value == 'string') filter.guard_name.value = value;
                      }
                    "
                    :label-click="
                      function () {
                        filter.guard_name.isActive = true;
                        filter.search = null;
                      }
                    "
                    :close-search-fn="
                      function () {
                        filter.guard_name.isActive = false;
                        filter.guard_name.value = null;
                      }
                    "
                    :filter="filter"
                    :set-order="setOrder"
                  />
                </th>
<th v-show="columns.group_name">                  
                  <Filterth
                    field="group_name"
                    label="Group Name"
                    searchable
                    sortable
                    @input="
                      (value) => {
                        if (typeof value == 'string') filter.group_name.value = value;
                      }
                    "
                    :label-click="
                      function () {
                        filter.group_name.isActive = true;
                        filter.search = null;
                      }
                    "
                    :close-search-fn="
                      function () {
                        filter.group_name.isActive = false;
                        filter.group_name.value = null;
                      }
                    "
                    :filter="filter"
                    :set-order="setOrder"
                  />
                </th>
                <th v-show="columns.action" style="width: 30px;"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(permission, index) in permissions.data">
                <td v-show="columns.id">{{ permission.id }}</td>
                <td v-show="columns.name">{{ permission.name }}</td>
                <td v-show="columns.guard_name">{{ permission.guard_name }}</td>
                <td v-show="columns.action" class="text-right">
                  <Dropdown stay :header="permission.name" :id="'permissionindex' + index">
                    <Button
                      btnDropdown
                      type="button"
                      @click="deletepermission(permission.delete_url)"
                    >
                      <i class="fa fa-trash"></i> Delete
                    </Button>
                    <Button btnDropdown type="button" @click="showModal(permission)">
                      <i class="fa fa-edit"></i> Edit
                    </Button>
                  </Dropdown>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="p-2">
            <Pagination @traped="loadingTable = true" :items="permissions" />
          </div>
        </Card>
      </div>
    </div>
  </Content>
  <Modal id="gate_permission_create_modal" :title="modalTitle" varient="light">
    <template #body>
      <form @submit.prevent="submit" novalidate="novalidate">
        <div class="form-group">
          <label for="form_input_name">Name</label>
          <input
            v-model="form.name"
            :disabled="form.processing"
            type="text"
            name="name"
            class="form-control"
            :class="{ 'is-invalid': form.errors.name }"
            id="form_input_name"
            placeholder="Permission name"
            aria-describedby="form_input_name-error"
            aria-invalid="true"
          />
          <span id="form_input_name-error" class="error invalid-feedback">{{ form.errors.name }}</span>
        </div>
<div class="form-group">
          <label for="form_input_guard_name">Guard Name</label>
          <input
            v-model="form.guard_name"
            :disabled="form.processing"
            type="text"
            name="guard_name"
            class="form-control"
            :class="{ 'is-invalid': form.errors.guard_name }"
            id="form_input_guard_name"
            placeholder="Permission guard name"
            aria-describedby="form_input_guard_name-error"
            aria-invalid="true"
          />
          <span id="form_input_guard_name-error" class="error invalid-feedback">{{ form.errors.guard_name }}</span>
        </div>
<div class="form-group">
          <label for="form_input_group_name">Group Name</label>
          <input
            v-model="form.group_name"
            :disabled="form.processing"
            type="text"
            name="group_name"
            class="form-control"
            :class="{ 'is-invalid': form.errors.group_name }"
            id="form_input_group_name"
            placeholder="Permission group name"
            aria-describedby="form_input_group_name-error"
            aria-invalid="true"
          />
          <span id="form_input_group_name-error" class="error invalid-feedback">{{ form.errors.group_name }}</span>
        </div>
      </form>
    </template>

    <template #action>
      <Button :isLoading="form.processing" :hideLabel="true" @click="submit">
        <i class="fa fa-save"></i>
      </Button>
    </template>
  </Modal>
  <DeleteConfirm :deleteUrl="deleteUrl" item="permission"/>
</template>

<script>
import {
  AdminLayout, Modal, Card, DeleteConfirm, Spinner, Dropdown, Pagination, Filterth, Button, Content, useValidateForm,
} from "@/Components";
import toast from '@/Store/toast.js';
import _ from "lodash";
import { Inertia } from "@inertiajs/inertia";
import { reactive, ref } from "vue";
import { isRequired } from "intus/rules";

export default {
  name: "Permission",
  layout: AdminLayout,
  components: {
    Spinner, Modal, Content, DeleteConfirm, Card, Button, Dropdown, Filterth, Pagination,
  },
  props: {
    permissions: Object,
    params: Object,
  },
  data() {
    return {
      form: useValidateForm({
                  name: [null, [isRequired()]],
          guard_name: [null, [isRequired()]],
          group_name: [null, [isRequired()]],
      }),

      filter: reactive({
        id: {
          isActive: this.params.id != null,
          value: this.params.id ?? null,
        },
        name: {
          isActive: this.params.name != null,
          value: this.params.name ?? null,
        },
guard_name: {
          isActive: this.params.guard_name != null,
          value: this.params.guard_name ?? null,
        },
group_name: {
          isActive: this.params.group_name != null,
          value: this.params.group_name ?? null,
        },
        order: {
          field: this.params.orderBy ?? null,
          direction: this.params.orderDirection ?? null,
        },
        search: this.params.search ?? null,
        per_page: this.params.per_page ?? 5,
      }),
      columns: reactive({
        id: true,
        name: true, 
        guard_name: true,
        action: true
      }),

      modal: {form: null, confirm: null},
      modalTitle: null,
      isEditing: false,
      editUrl: null,
      deleteUrl: null,
      loadingTable: false,
    };
  },
  watch: {
    filter: {
      handler: _.debounce(function (state, old) {
        let query = {};
        if (state.search) {
          for (const field in this.filter) {
            if (["order", "search", "per_page"].indexOf(field) != -1) continue;
            this.filter[field].isActive = false;
            this.filter[field].value = null;
          }
        }
        for (const field in state) {
          if (["order", "search", "per_page"].indexOf(field) != -1) continue;
          if (state[field].value) {
            query[field] = state[field].value;
          }
        }
        if (state.order.field && state.order.direction) {
          query.orderBy = state.order.field;
          query.orderDirection = state.order.direction;
        }
        if (state.search) query.search = state.search;
        if (state.per_page) query.per_page = state.per_page;
        
        this.getpermissions(query);
      }, 1000),
      deep: true,
    },
  },
  mounted() {
    let form = document.querySelector("#gate_permission_create_modal");
    let confirm = document.querySelector("#confirmModel");
    this.modal.form = new bootstrap.Modal(form);
    this.modal.confirm = new bootstrap.Modal(confirm);
  },
  methods: {
    setOrder(field) {
      if (this.filter.order.field != field && this.filter.order.direction) {
        this.filter.order.direction = "asc";
      } else {
        this.filter.order.direction = !this.filter.order.direction ? "asc" : this.filter.order.direction == "asc" ? "desc" : this.filter.order.direction == "desc" ? null : null;
      }
      this.filter.order.field = field;
    },
    getpermissions(filter = {}) {
      this.loadingTable = true;
      Inertia.get(this.route("gate.permission.index"), filter, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        onSuccess: () => {
          this.loadingTable = false;
        },
        onError: error => {
          this.loadingTable = false;
          let message = '';
          for(let key in error){
            message += error[key] + ' ';
          }
          toast.add({
            type: 'error',
            message
          })
        }
      });
    },
    showModal(data = null) {
      this.isEditing = data !== null;
      this.modalTitle = data == null ? "Create Permission" : "Update Permission";
      this.form.clearErrors();
      if (this.isEditing) {
        this.editUrl = data.edit_url;
                  this.form.name = data.name;
          this.form.guard_name = data.guard_name;
          this.form.group_name = data.group_name;
      } else {
        this.form.reset();
      }
      this.modal.form.show();
    },
    submit() {
      this.form.clearErrors();
      var url = this.isEditing ? this.editUrl : route("gate.permission.store");
      this.form.post(url, {
        preserveScroll: true,
        onSuccess: () => {
          this.form.reset();
          this.modal.form.hide();
        },
      });
    },
    update() {
      this.form.clearErrors();
      this.form.post(this.editUrl, {
        preserveScroll: true,
        onSuccess: () => {
          this.form.reset();
          this.modal.form.hide();
        },
      });
    },
    deletepermission(url) {
      this.deleteUrl = url;
      this.modal.confirm.show();
      Inertia.on('finish', () => {
        this.deleteUrl = null
        this.modal.confirm.hide()
      })
    },
  },
};
</script>

