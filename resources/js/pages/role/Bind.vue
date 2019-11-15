<template>
  <div>
    <el-dialog title="绑定菜单" :visible="visible" @close="() => cancel()">
      <el-input v-model="filterText" placeholder="搜索菜单" style="margin-bottom:30px;" />
      <el-tree
        ref="bindMenuTree"
        :data="menuTree"
        :props="defaultProps"
        :filter-node-method="filterNode"
        class="filter-tree"
        node-key="id"
        default-expand-all
        show-checkbox
        :expand-on-click-node="false"
        :default-checked-keys="bindMenuIds"
      />
      <div slot="footer" class="dialog-footer">
        <el-button @click="() => cancel()">取 消</el-button>
        <el-button type="primary" @click="() => success()">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>

export default {
  name: `RoleBind`,
  components: {},
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
      defaultProps: {
        children: 'children',
        label: 'name'
      },
      filterText: ''
    }
  },
  computed: {
    visible() {
      const { visible } = this.$store.state.role.bindProps
      return visible
    },
    menuTree() {
      return this.$store.state.menu.allTree
    },
    bindMenuIds() {
      return this.$store.state.role.bindProps.bindMenuIds
    }
  },
  watch: {
    filterText(val) {
      this.$refs.bindMenuTree.filter(val)
    }
  },
  created() {},
  methods: {
    cancel() {
      this.$store.commit('role/SET_BIND_PROPS', { visible: false, bindMenuIds: [] })
    },
    success() {
      const checkedNodes = this.getCheckedNodes()
      const menuIds = checkedNodes.map(item => item.id)
      if (menuIds.length === 0) {
        this.$message({
          message: '您没有选择菜单',
          type: 'warning'
        })
        return
      }
      this.$api.role.bindMenu(this.id, { menuIds }).then(() => {
        this.cancel()
        this.$message({
          message: '操作成功',
          type: 'success'
        })
      })
    },
    filterNode(value, data) {
      if (!value) return true
      return data.name.indexOf(value) !== -1
    },
    getCheckedNodes() {
      return this.$refs.bindMenuTree.getCheckedNodes()
    }
  }
}

</script>

<style scoped>

</style>
