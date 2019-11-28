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
        label="姓名"
      />
      <el-table-column
        prop="mobile"
        label="电话"
      />
      <el-table-column
        prop="email"
        label="邮箱"
      />
      <el-table-column
        prop="nickname"
        label="昵称"
      />
      <el-table-column
        label="操作"
        fixed="right"
        width="400"
      >
        <template slot-scope="scope">
          <el-button
            size="mini"
            @click="updatePassword(scope.$index, scope.row)"
          >重置密码</el-button>
          <el-button
            size="mini"
            @click="bindRole(scope.$index, scope.row)"
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
    <user-form
      :id="id"
      @success="submitSuccess"
    />
    <user-bind
      :id="id"
    />
    <update-password
      :id="id"
    />
  </div>
</template>

<script>
import SearchBox from '../../components/SearchBox/index'
import Pagination from '../../components/Pagination/index'
import UserForm from './Form'
import UserBind from './Bind'
import UpdatePassword from './Password'
export default {
  components: { UpdatePassword, UserForm, UserBind, SearchBox, Pagination },
  data() {
    return {
      id: null,
      searchProps: {
        list: [{
          type: 'input',
          label: '名字',
          value: '',
          key: 'name'
        }, {
          type: 'input',
          label: '电话',
          value: '',
          key: 'mobile'
        }, {
          type: 'input',
          label: '邮箱',
          value: '',
          key: 'email'
        }],
        callback: this.search
      }
    }
  },
  computed: {
    list() {
      return this.$store.state.user.list
    }
  },
  created() {
    this.$store.dispatch('user/getList')
  },
  methods: {
    search: function(params = {}) {
      this.$store.dispatch('user/getList', params)
    },
    handleCreate() {
      this.id = null
      this.$store.commit('user/SET_FORM_PROPS', { visible: true, name: '添加' })
    },
    update(index, row) {
      this.id = row.id
      this.$store.dispatch('user/getDetail', { id: this.id })
      this.$store.commit('user/SET_FORM_PROPS', { visible: true, name: '编辑' })
    },
    updatePassword(index, row) {
      this.id = row.id
      this.$store.commit('user/SET_UPDATE_PASSWORD_PROPS', { visible: true })
    },
    remove(index, row) {
      const { id } = row
      this.$confirm('是否删除此用户？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.$api.user.remove(id).then(() => {
          this.submitSuccess({})
          this.$message({
            type: 'success',
            message: '删除成功!'
          })
        })
      })
    },
    bindRole(index, { id }) {
      this.id = id
      this.$store.commit('user/SET_BIND_PROPS', { visible: true })
    },
    submitSuccess() {
      this.resetSearch()
    },
    resetSearch() {
      this.searchProps.list = this.searchProps.list.map(item => {
        item.value = ''
        return item
      })
      this.$store.dispatch('user/getList')
    }
  }
}
</script>

<style scoped>
  .row-bg {
    padding: 10px 0;
  }
</style>
