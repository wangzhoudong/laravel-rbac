<template>
  <div>
    <el-dialog :title="name + '菜单'" :visible="visible" @close="() => cancel()">
      <el-form :model="form">
        <el-form-item label="菜单名称" :label-width="formLabelWidth">
          <el-input v-model="form.name" size="medium" autocomplete="off" />
        </el-form-item>
        <el-form-item label="父菜单" :label-width="formLabelWidth">
          <el-select v-model="form.pid" :disabled="disabled" placeholder="请选择父菜单" style="width: 100%;">
            <el-option v-for="menu in selectMenuList" :key="menu.id" size="medium" :label="menu.name" :value="menu.id" />
          </el-select>
        </el-form-item>
        <el-form-item label="URL" :label-width="formLabelWidth">
          <el-input v-model="form.url" size="medium" autocomplete="off" />
        </el-form-item>
        <el-form-item label="ICON" :label-width="formLabelWidth">
          <el-autocomplete
            v-model="form.ico"
            size="medium"
            :fetch-suggestions="querySearch"
            placeholder="请输入ICON"
            style="width: 100%;"
            @select="handleSelect"
          />
        </el-form-item>
        <el-form-item label="排序" :label-width="formLabelWidth">
          <el-input v-model="form.sort" size="medium" autocomplete="off" />
        </el-form-item>
        <el-form-item label="备注" :label-width="formLabelWidth">
          <el-input v-model="form.remark" size="medium" autocomplete="off" />
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" :loading="submitLoading" @click="() => submit()">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
export default {
  name: 'MenuForm',
  props: {
    // eslint-disable-next-line vue/require-default-prop
    id: {
      type: Number,
      required: false
    }
  },
  data() {
    return {
      formLabelWidth: '80px',
      selectMenuList: [],
      submitLoading: false,
      disabled: false,
      icons: [
        { 'value': 'dashboard' },
        { 'value': 'example' },
        { 'value': 'eye' },
        { 'value': 'eye-open' },
        { 'value': 'form' },
        { 'value': 'link' },
        { 'value': 'nested' },
        { 'value': 'password' },
        { 'value': 'table' },
        { 'value': 'tree' },
        { 'value': 'user' }
      ]
    }
  },
  computed: {
    visible() {
      return this.$store.state.menu.formProps.visible
    },
    name() {
      return this.$store.state.menu.formProps.modelName
    },
    form: {
      set: function(newVal) {
        console.log(newVal)
      },
      get: function() {
        return this.$store.state.menu.item
      }
    }
  },
  watch: {
    visible(val) {
      if (val) {
        const { modelName } = this.$store.state.menu.formProps
        const id = this.id || 0
        if (id && id > 0 && modelName === '编辑') {
          this.disabled = true
          this.$store.dispatch('menu/getItem', id)
        } else {
          this.$store.commit('menu/SET_ITEM', { item: { pid: id }})
        }
      }
    }
  },
  created() {
    this.getMenus()
  },
  methods: {
    getMenus() {
      this.$api.menu.getAll({ pid: 0 }).then(({ data }) => {
        data.unshift({
          id: 0,
          name: '顶级分类'
        })
        this.selectMenuList = data
      })
    },
    cancel() {
      this.$store.commit('menu/SET_ITEM', { item: {}})
      this.$store.commit('menu/SET_FORM_PROPS', { visible: false })
    },
    async submit() {
      this.submitLoading = true
      const { modelName } = this.$store.state.menu.formProps
      const id = this.id
      try {
        if (modelName === '编辑') {
          const data = await this.$api.menu.update(id, this.form)
          this.$emit('success', { type: 'update', data: data })
        } else {
          const data = await this.$api.menu.append(this.form)
          this.$emit('success', { type: 'append', data: data })
        }
        this.getMenus()
        await this.cancel()
        this.$message({
          message: '操作成功',
          type: 'success'
        })
      } catch (e) {
        console.log(e)
      }
      this.submitLoading = false
    },
    querySearch(queryString, callback) {
      const icons = this.icons
      const results = queryString ? icons.filter(this.createFilter(queryString)) : icons
      callback(results)
    },
    createFilter(queryString) {
      return (icon) => (icon.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0)
    },
    handleSelect(item) {
      console.log(item)
    }
  }
}
</script>

<style scoped>

</style>
