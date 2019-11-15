<template>
  <div>
    <el-dialog title="绑定API" :visible="visible" @close="() => cancel()">
      <search-box
        v-bind="searchProps"
      />
      <el-table
        ref="bindApiTable"
        :data="list.data"
        tooltip-effect="dark"
        style="width: 100%"
        :row-key="handleReserve"
        @selection-change="handleSelectionChange"
      >
        <el-table-column
          type="selection"
          width="55"
          reserve-selection
        />
        <el-table-column
          prop="name"
          label="名称"
          width="120"
        />
        <el-table-column
          prop="path"
          label="URL"
          width="120"
        />
        <el-table-column
          prop="method"
          label="请求类型"
          show-overflow-tooltip
        />
        <el-table-column
          prop="module"
          label="模块"
          show-overflow-tooltip
        />
      </el-table>
      <pagination
        :list="list"
        action="api/getList"
      />
      <div slot="footer" class="dialog-footer">
        <el-button @click="() => cancel()">取 消</el-button>
        <el-button type="primary" @click="() => success()">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import SearchBox from '../../components/SearchBox/index'
import Pagination from '../../components/Pagination/index'

export default {
  name: `MenuBind`,
  components: { SearchBox, Pagination },
  props: {
    // eslint-disable-next-line vue/require-default-prop
    id: {
      type: Number,
      required: false
    }
  },
  data() {
    return {
      multipleSelection: [],
      searchProps: {
        list: [{
          type: 'input',
          value: '',
          label: '名称',
          key: 'name'
        }, {
          type: 'input',
          value: '',
          label: 'URL',
          key: 'path'
        }, {
          type: 'select',
          value: '',
          label: '模块',
          key: 'module',
          options: []
        }],
        callback: this.search
      }
    }
  },
  computed: {
    visible() {
      return this.$store.state.menu.bindProps.visible
    },
    list() {
      return this.$store.state.api.list
    }
  },
  watch: {
    async visible(val) {
      if (val) {
        await this.$store.dispatch('menu/getBindApis', this.id)
        this.toggleSelection()
      } else {
        this.$refs.bindApiTable.clearSelection()
      }
    }
  },
  created() {
    this.$store.dispatch('api/getList')
    this.refreshModulesOptions()
  },
  methods: {
    cancel() {
      this.$store.commit('menu/SET_BIND_PROPS', { visible: false })
    },
    handleSelectionChange(val) {
      this.multipleSelection = val
    },
    search(params) {
      this.$store.dispatch('api/getList', params)
    },
    success() {
      if (this.multipleSelection.length === 0) {
        this.$message({
          message: '您没有选择API',
          type: 'warning'
        })
        return
      }
      const apiIds = this.multipleSelection.map(item => {
        return item.id
      })
      this.$api.menu.bindApi(this.id, { apiIds }).then(() => {
        this.cancel()
        this.$message({
          message: '操作成功',
          type: 'success'
        })
      })
    },
    refreshModulesOptions(modules = {}) {
      if (Object.keys(modules).length === 0) {
        this.$store.dispatch('api/getModules').then((data) => {
          this.searchProps.list[2].options = data
        })
      }
    },
    toggleSelection() {
      const { bindApis } = this.$store.state.menu.bindProps
      if (bindApis.length > 0) {
        const clickRows = this.list.data.filter(item => bindApis.findIndex(e => e === item.id) > -1)
        if (this.$refs.bindApiTable) {
          clickRows.forEach(clickRow => {
            this.$refs.bindApiTable.toggleRowSelection(clickRow, true)
          })
        }
      }
    },
    handleReserve(row) {
      return row.id
    }
  }
}

</script>

<style scoped>

</style>
