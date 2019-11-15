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
      <el-table-column
        label="操作"
        show-overflow-tooltip
      >
        <template slot-scope="scope">
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
      action="api/getList"
    />
    <api-form
      :id="id"
      @success="submitSuccess"
    />
  </div>
</template>

<script>
import SearchBox from '../../components/SearchBox/index'
import Pagination from '../../components/Pagination/index'
import ApiForm from './Form'
export default {
  components: { ApiForm, SearchBox, Pagination },
  data() {
    return {
      id: null,
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
    list() {
      return this.$store.state.api.list
    }
  },
  created() {
    this.$store.dispatch('api/getList')
    this.refreshModulesOptions()
  },
  methods: {
    search(params) {
      this.$store.dispatch('api/getList', params)
    },
    handleCreate() {
      this.$store.commit('api/SET_FORM_PROPS', { visible: true, name: '添加' })
    },
    update(index, row) {
      this.id = row.id
      this.$store.commit('api/SET_FORM_PROPS', { visible: true, name: '编辑' })
    },
    remove(index, row) {
      const { id } = row
      this.$confirm('是否删除此API？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.$api.api.remove(id).then(() => {
          this.submitSuccess({})
          this.$message({
            type: 'success',
            message: '删除成功!'
          })
        })
      })
    },
    submitSuccess({ type, data }) {
      this.resetSearch()
      this.refreshModulesOptions()
    },
    resetSearch() {
      this.searchProps.list = this.searchProps.list.map(item => {
        item.value = ''
        return item
      })
      this.$store.dispatch('api/getList')
    },
    refreshModulesOptions(modules = {}) {
      if (Object.keys(modules).length === 0) {
        this.$store.dispatch('api/getModules').then((data) => {
          modules = data
          this.searchProps.list[2].options = modules
        })
      }
    }
  }
}
</script>

<style scoped>
  .row-bg {
    padding: 10px 0;
  }
</style>
