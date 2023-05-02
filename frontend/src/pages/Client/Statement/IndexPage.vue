<template>
  <q-page style="display: grid;">
    <div class="q-pa-md column">
      <div class="col">
        <q-table
          :rows-per-page-options="[pagination.rowsPerPage]"
          :columns="columns"
          :filter="filter"
          :rows="data"
          row-key="id"
          :pagination="pagination"
          @request="onRequest"
        >
          <template v-slot:top-left>
            Statements
          </template>
          <template v-slot:top-right>
            <q-btn class="q-mx-md q-px-md" dense color="primary" no-caps icon="mdi-plus" label="Add" @click="storeStatement(null)" />
            <q-input debounce="600" filled dense v-model="filter" label="Search">
              <template v-slot:append>
                <q-icon name="mdi-magnify" />
              </template>
            </q-input>
          </template>
          <template v-slot:body="props">
            <q-tr class="cursor-pointer" :props="props" @click="storeStatement(props.row)">
              <q-td key="menu">
                <q-btn flat dense round icon="mdi-dots-vertical" @click.stop.prevent>
                  <q-menu>
                    <q-list style="min-width: 150px;">
                      <q-item clickable v-close-popup @click="storeStatement(props.row)">
                        <q-item-section avatar><q-icon name="mdi-pencil" color="primary" /></q-item-section>
                        <q-item-section>Edit</q-item-section>
                      </q-item>
                      <q-item clickable v-close-popup @click="deleteStatement(props.row.id)">
                        <q-item-section avatar><q-icon name="mdi-delete" color="red" /></q-item-section>
                        <q-item-section>Delete</q-item-section>
                      </q-item>
                    </q-list>
                  </q-menu>
                </q-btn>
              </q-td>
              <q-td key="id">{{ props.row.id }}</q-td>
              <q-td key="name">{{ props.row.name }}</q-td>
              <q-td key="date">{{ props.row.date }}</q-td>
              <q-td key="created_at">{{ props.row.created_at }}</q-td>
              <q-td key="updated_at">{{ props.row.updated_at }}</q-td>
            </q-tr>
          </template>
        </q-table>
      </div>
    </div>

    <StatementDialog v-model:dialog="statementDialogShow" :info="statementDialogData" @reload="loadStatements" />
    <q-inner-loading :showing="loading">
      <q-spinner size="30px" color="primary" />
    </q-inner-loading>
  </q-page>
</template>

<script>
import _ from 'lodash'
import StatementDialog from './StatementDialog'

export default {
  name: 'IndexPage',
  components: { StatementDialog },
  data () {
    return {
      loading: false,
      filter: '',
      data: [],
      columns: [
        { name: 'menu', align: 'left' },
        { name: 'id', label: 'ID', align: 'left', field: 'id' },
        { name: 'name', label: 'Name', align: 'left', field: 'name' },
        { name: 'date', label: 'Date', align: 'left', field: 'date' },
        { name: 'created_at', label: 'Create Date', align: 'left', field: 'created_at' },
        { name: 'updated_at', label: 'Update Date', align: 'left', field: 'updated_at' },
      ],
      pagination: {
        sortBy: 'id',
        descending: true,
        page: 1,
        rowsPerPage: 8,
        rowsNumber: 0
      },
      statementDialogShow: false,
      statementDialogData: []
    }
  },
  mounted() {
    this.loadStatements()
  },
  methods: {
    onRequest (props) {
      const app = this
      app.loading = true
      var params = {
        params: {
          sortBy: props.pagination.sortBy,
          descending: props.pagination.descending,
          page: props.pagination.page,
          rowsPerPage: props.pagination.rowsPerPage,
          search: props.filter,
        }
      }

      app.$axios.get(app.$s.api + 'api/v1/panel/client/statement', params)
        .then(function (response) {
          if (response.data.success) {
            app.data = response.data.data
            app.rowsNumber = response.data.meta.total
          } else {
            app.notify(response.data.message)
          }
        })
        .finally(function () {
          app.loading = false
        })
    },
    loadStatements () {
      this.onRequest({ pagination: this.pagination, filter: this.filter })
    },
    deleteStatement (id) {
      const app = this
      app.$q.dialog({
        title: 'Delete',
        message: 'Are you sure to delete this statement?',
        ok: 'Yes',
        cancel: 'No'
      }).onOk(() => {
        app.loading = true
        app.$axios.delete(app.$s.api + 'api/v1/panel/client/statement/' + id)
          .then(function (response) {
            if (response.data.success) {
              app.loadStatements()
            }
            app.notify(response.data.message)
          })
          .finally(function () {
            app.loading = false
          })
      })
    },
    storeStatement (data) {
      if (data === null) {
        this.statementDialogData = {
          id: 0,
          name: '',
          date: ''
        }
      } else {
        this.statementDialogData = _.cloneDeep(data)
      }
      this.statementDialogShow = true
    },
  }
}
</script>
