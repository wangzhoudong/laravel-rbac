<template>
  <div>
    <el-dialog :title="name + '用户'" :visible="visible" @close="() => cancel()">
      <el-form ref="userForm" :model="form" :label-width="formLabelWidth" :rules="rules" size="medium">
        <el-form-item label="名字" prop="name">
          <el-input v-model="form.name" autocomplete="off" />
        </el-form-item>
        <el-form-item label="昵称" prop="nickname">
          <el-input v-model="form.nickname" autocomplete="off" />
        </el-form-item>
        <el-form-item label="手机号码" prop="mobile">
          <el-input v-model="form.mobile" autocomplete="off" />
        </el-form-item>
        <el-form-item label="邮箱" prop="email">
          <el-input v-model="form.email" autocomplete="off" />
        </el-form-item>
        <el-form-item v-if="!id" label="密码" prop="password">
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
  name: 'UserForm',
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
      rules: {
        name: [
          { required: true, message: '请输入名字', trigger: 'blur' },
          { min: 2, max: 10, message: '长度在 2 到 10 个字符', trigger: 'blur' }
        ],
        nickname: [
          { min: 2, max: 10, message: '长度在 2 到 10 个字符', trigger: 'blur' }
        ],
        mobile: [
          { required: true, message: '请输入手机号码', trigger: 'blur' },
          { pattern: /^1[0-9]{10}$|^[569][0-9]{7}$/, message: '请填写正确的手机号码' }
        ],
        email: [
          { required: true, message: '请输入邮箱', trigger: 'blur' },
          { type: 'email', message: '请输入合法的邮箱' }
        ],
        password: [
          { required: true, message: '请输入密码', trigger: 'blur' },
          { min: 6, max: 18, message: '长度在 6 到 18 个字符', trigger: 'blur' }
        ]
      }
    }
  },
  computed: {
    visible() {
      const { visible } = this.$store.state.user.formProps
      return visible
    },
    name() {
      return this.$store.state.user.formProps.name
    },
    form() {
      return this.$store.state.user.item
    }
  },
  watch: {
    visible(val) {}
  },
  created() {},
  methods: {
    init() {
      this.$store.commit('user/SET_ITEM', { item: {}})
    },
    cancel() {
      this.init()
      this.$store.commit('user/SET_FORM_PROPS', { visible: false })
    },
    async submit() {
      this.$refs.userForm.validate(async valid => {
        if (valid) {
          this.submitLoading = true
          const id = this.id
          try {
            if (id && id > 0) {
              const data = await this.$api.user.update(id, this.form)
              this.$emit('success', { type: 'update', data: data })
            } else {
              const data = await this.$api.user.append(this.form)
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
