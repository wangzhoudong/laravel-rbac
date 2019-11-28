<template>
  <div class="app-container">
    <el-row class="row-bg">
      <div>
        <el-button
          plain
          size="small"
          @click="() => append()"
        >
          新建
        </el-button>
      </div>
    </el-row>
    <el-input v-model="filterText" placeholder="搜索菜单" style="margin-bottom:30px;" />
    <el-tree
      ref="tree2"
      :data="data2"
      :props="defaultProps"
      :filter-node-method="filterNode"
      class="filter-tree"
      node-key="id"
      default-expand-all
      :expand-on-click-node="false"
    >
      <span slot-scope="{ node, data }" class="custom-tree-node">
        <span>{{ node.label }}</span>
        <span>
          <el-button
            type="text"
            size="mini"
            @click="() => bind(data)"
          >
            绑定
          </el-button>
          <el-button
            v-if="parseInt(data.pid) === 0"
            type="text"
            size="mini"
            @click="() => append(data)"
          >
            新建
          </el-button>
          <el-button
            type="text"
            size="mini"
            @click="() => update(data)"
          >
            编辑
          </el-button>
          <el-button
            type="text"
            size="mini"
            @click="() => remove(node, data)"
          >
            删除
          </el-button>
        </span>
      </span>
    </el-tree>
    <!--    模态框部分-->
    <menu-form
      :id="id"
      @success="submitSuccess"
    />
    <menu-bind
      :id="id"
      @success="bindSuccess"
    />
  </div>
</template>

<script>
import MenuForm from './Form'
import MenuBind from './Bind'
export default {
  components: { MenuBind, MenuForm },
  data() {
    return {
      filterText: '',
      defaultProps: {
        children: 'children',
        label: 'name'
      },
      id: null
    }
  },
  computed: {
    data2() {
      return this.$store.state.menu.allTree
    }
  },
  watch: {
    filterText(val) {
      this.$refs.tree2.filter(val)
    }
  },
  created: function() {
    this.$store.dispatch('menu/getAll')
  },
  methods: {
    append(data = {}) {
      this.$store.commit('menu/SET_FORM_PROPS', { visible: true, modelName: '新建' })
      if (data.id) {
        this.id = data.id
      } else {
        this.id = 0
      }
    },
    bind(data) {
      console.log(data)
      this.id = data.id
      this.$store.commit('menu/SET_BIND_PROPS', { visible: true })
    },
    update(data) {
      this.id = data.id
      this.$store.commit('menu/SET_FORM_PROPS', { visible: true, modelName: '编辑' })
    },
    remove(node, data) {
      const { id } = data
      this.$confirm('是否删除此菜单？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.$api.menu.remove(id).then(() => {
          this.$store.dispatch('menu/getAll')
          this.$message({
            type: 'success',
            message: '删除成功!'
          })
        })
      })
    },
    filterNode(value, data) {
      if (!value) return true
      return data.name.indexOf(value) !== -1
    },
    submitSuccess({ type, data }) {
      this.$store.dispatch('menu/getAll')
    },
    bindSuccess(data) {
      console.log(data)
    }
  }
}
</script>

<style>
  .row-bg {
    padding: 10px 0;
  }

  .custom-tree-node {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    padding-right: 8px;
  }
</style>

