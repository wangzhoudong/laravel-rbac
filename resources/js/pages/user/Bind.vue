<template>
  <div>
    <el-dialog title="绑定API" :visible="visible" @close="() => cancel()">
      <search-box
        v-bind="searchProps"
      />
      <el-table
        ref="bindRoleTable"
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
  name: `UserBind`,
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
        }],
        callback: this.search
      }
    }
  },
  computed: {
    visible() {
      return this.$store.state.user.bindProps.visible
    },
    list() {
      return this.$store.state.role.list
    }
  },
  watch: {
    visible(val) {
      if (val) {
        this.$store.dispatch('role/getList')
        this.$store.dispatch('user/getBindRoleIds', { id: this.id }).then(() => {
          this.toggleSelection()
        })
      } else {
        this.$refs.bindRoleTable.clearSelection()
      }
    }
  },
  created() {
    // this.$store.dispatch('api/getList')
    // this.refreshModulesOptions()
  },
  methods: {
    cancel() {
      this.$store.commit('user/SET_BIND_PROPS', { visible: false })
    },
    handleSelectionChange(val) {
      this.multipleSelection = val
    },
    search(params) {
      this.$store.dispatch('role/getList', params)
    },
    success() {
      if (this.multipleSelection.length === 0) {
        this.$message({
          message: '您没有选择角色',
          type: 'warning'
        })
        return
      }
      const roleIds = this.multipleSelection.map(item => {
        return item.id
      })
      this.$api.user.bindRole(this.id, { roleIds }).then(() => {
        this.cancel()
        this.$message({
          message: '操作成功',
          type: 'success'
        })
      })
    },
    toggleSelection() {
      const { bindRoleIds } = this.$store.state.user.bindProps
      if (bindRoleIds.length > 0) {
        const clickRows = this.list.data.filter(item => bindRoleIds.findIndex(e => e === item.id) > -1)
        if (this.$refs.bindRoleTable) {
          clickRows.forEach(clickRow => {
            this.$refs.bindRoleTable.toggleRowSelection(clickRow, true)
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
