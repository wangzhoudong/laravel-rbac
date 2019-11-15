<template>
  <div class="app-container">
    <el-row class="row-bg">
      <div>
        <el-button
          plain
          size="small"
          @click="() => handleCreate()"
        >
          新建
        </el-button>
      </div>
    </el-row>
    <search-box
      v-bind="searchProps"
    />
    <el-table
      :data="list.data"
      tooltip-effect="dark"
      style="width: 100%"
      size="mini"
    >
      <el-table-column
        prop="name"
        label="名称"
      />
      <el-table-column
        label="操作"
        show-overflow-tooltip
      >
        <template slot-scope="scope">
          <el-button
            size="mini"
            @click="bindMenu(scope.$index, scope.row)"
          >绑定</el-button>
          <el-button
            size="mini"
            @click="update(scope.$index, scope.row)"
          >编辑</el-button>
          <el-button
            size="mini"
            type="danger"
            @click="remove(scope.$index, scope.row)"
          >删除</el-button>
        </template>
      </el-table-column>
    </el-table>
    <pagination
      v-if="list.total > 0"
      :list="list"
      action="role/getList"
    />
    <role-form
      :id="id"
      @success="submitSuccess"
    />
    <role-bind
      :id="id"
    />
  </div>
</template>

<script>
import SearchBox from '../../components/SearchBox/index'
import Pagination from '../../components/Pagination/index'
import RoleForm from './Form'
import RoleBind from './Bind'
export default {
  components: { RoleBind, RoleForm, SearchBox, Pagination },
  data() {
    return {
      id: null,
      searchProps: {
        list: [{
          type: 'input',
          label: '名字',
          value: '',
          key: 'name'
        }],
        callback: this.search
      }
    }
  },
  computed: {
    list() {
      return this.$store.state.role.list
    }
  },
  created() {
    this.$store.dispatch('role/getList')
  },
  methods: {
    search: function() {
      console.log(2)
    },
    handleCreate() {
      this.id = null
      this.$store.commit('role/SET_FORM_PROPS', { visible: true, name: '添加' })
    },
    update(index, row) {
      this.id = row.id
      this.$store.dispatch('role/getDetail', { id: this.id })
      this.$store.commit('role/SET_FORM_PROPS', { visible: true, name: '编辑' })
    },
    remove(index, row) {
      const { id } = row
      this.$confirm('是否删除此角色？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.$api.role.remove(id).then(() => {
          this.submitSuccess({})
          this.$message({
            type: 'success',
            message: '删除成功!'
          })
        })
      })
    },
    bindMenu(index, { id }) {
      this.id = id
      this.$store.dispatch('menu/getAll')
      this.$store.dispatch('role/getBindMenuIds', { id })
      this.$store.commit('role/SET_BIND_PROPS', { visible: true })
    },
    submitSuccess() {
      this.resetSearch()
    },
    resetSearch() {
      this.searchProps.list = this.searchProps.list.map(item => {
        item.value = ''
        return item
      })
      this.$store.dispatch('role/getList')
    }
  }
}
</script>

<style scoped>
  .row-bg {
    padding: 10px 0;
  }
</style>
