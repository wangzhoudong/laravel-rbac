<template>
  <div>
    <el-dialog title="重置密码" :visible="visible" @close="() => cancel()">
      <el-form ref="passwordForm" :model="form" :label-width="formLabelWidth" :rules="rules" size="medium">
        <el-form-item label="新密码" prop="password">
          <el-input v-model="form.password" autocomplete="off" />
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
  name: 'UpdatePassword',
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
      submitLoading: false,
      form: {},
      rules: {
        password: [
          { required: true, message: '请输入密码', trigger: 'blur' },
          { min: 6, max: 18, message: '长度在 6 到 18 个字符', trigger: 'blur' }
        ]
      }
    }
  },
  computed: {
    visible() {
      const { visible } = this.$store.state.user.updatePasswordProps
      return visible
    }
  },
  watch: {
    visible(val) {}
  },
  created() {},
  methods: {
    cancel() {
      this.form = {}
      this.$store.commit('user/SET_UPDATE_PASSWORD_PROPS', { visible: false })
    },
    async submit() {
      this.$refs.passwordForm.validate(async valid => {
        if (valid) {
          this.submitLoading = true
          const id = this.id
          console.log(id)
          try {
            await this.$api.user.updatePassword(id, this.form)
            await this.cancel()
            this.$message({
              message: '操作成功',
              type: 'success'
            })
          } catch (e) {
            console.log(e)
          }
          this.submitLoading = false
        } else {
          this.$message({
            message: '表单填写有误，请检查',
            type: 'warning'
          })
        }
      })
    }
  }
}
</script>

<style scoped>

</style>
