<template>
  <div>
    <el-dialog :title="name + '角色'" :visible="visible" @close="() => cancel()">
      <el-form :model="form">
        <el-form-item label="角色名称" :label-width="formLabelWidth">
          <el-input v-model="form.name" size="medium" autocomplete="off" />
        </el-form-item>
        <el-form-item label="备注" :label-width="formLabelWidth">
          <el-input v-model="form.mark" size="medium" autocomplete="off" />
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
  name: 'RoleForm',
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
      submitLoading: false
    }
  },
  computed: {
    visible() {
      const { visible } = this.$store.state.role.formProps
      return visible
    },
    name() {
      return this.$store.state.role.formProps.name
    },
    form() {
      return this.$store.state.role.item
    }
  },
  watch: {
    visible(val) {}
  },
  created() {},
  methods: {
    init() {
      this.$store.commit('role/SET_ITEM', { item: {}})
    },
    cancel() {
      this.init()
      this.$store.commit('role/SET_FORM_PROPS', { visible: false })
    },
    async submit() {
      this.submitLoading = true
      const id = this.id
      try {
        if (id && id > 0) {
          const data = await this.$api.role.update(id, this.form)
          this.$emit('success', { type: 'update', data: data })
        } else {
          const data = await this.$api.role.append(this.form)
          this.$emit('success', { type: 'append', data: data })
        }
        await this.cancel()
        this.$message({
          message: '操作成功',
          type: 'success'
        })
      } catch (e) {
        console.log(e)
      }
      this.submitLoading = false
    }
  }
}
</script>

<style scoped>

</style>
