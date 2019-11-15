<template>
  <div>
    <el-dialog :title="name + 'API'" :visible="visible" @close="() => cancel()">
      <el-form :model="form">
        <el-form-item label="API名称" :label-width="formLabelWidth">
          <el-input v-model="form.name" size="medium" autocomplete="off" />
        </el-form-item>
        <el-form-item label="URL" :label-width="formLabelWidth">
          <el-input v-model="form.path" size="medium" autocomplete="off" />
        </el-form-item>
        <el-form-item label="请求方法" :label-width="formLabelWidth">
          <el-select v-model="form.method" placeholder="请选择请求方法" style="width: 100%;">
            <el-option v-for="method in methods" :key="method.value" size="medium" :label="method.label" :value="method.value" />
          </el-select>
        </el-form-item>
        <el-form-item label="模块" :label-width="formLabelWidth">
          <el-autocomplete
            v-model="form.module"
            size="medium"
            :fetch-suggestions="querySearch"
            placeholder="请输入模块"
            style="width: 100%;"
            @select="handleSelect"
          />
        </el-form-item>
        <el-form-item label="启用" :label-width="formLabelWidth">
          <el-switch v-model="form.enable" :active-value="1" :inactive-value="0"></el-switch>
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
  name: 'ApiForm',
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
      form: {},
      submitLoading: false,
      modules: [],
      methods: [
        {
          label: 'GET',
          value: 'get'
        }, {
          label: 'POST',
          value: 'post'
        }, {
          label: 'PUT',
          value: 'put'
        }, {
          label: 'DELETE',
          value: 'delete'
        }, {
          label: 'ANYWAY',
          value: 'anyway'
        }
      ]
    }
  },
  computed: {
    visible() {
      return this.$store.state.api.formProps.visible
    },
    name() {
      return this.$store.state.api.formProps.name
    }
  },
  watch: {
    visible(val) {
      if (val) {
        // 拉取module
        this.$store.dispatch('api/getModules')
        const id = this.id || 0
        if (id && id > 0) {
          this.$api.api.find(id).then(({ data }) => {
            this.form = data
          })
        }
      }
    }
  },
  created() {},
  methods: {
    cancel() {
      this.$store.commit('api/SET_FORM_PROPS', { visible: false })
    },
    async submit() {
      this.submitLoading = true
      const id = this.id
      try {
        if (id && id > 0) {
          const data = await this.$api.api.update(id, this.form)
          this.$emit('success', { type: 'update', data: data })
        } else {
          const data = await this.$api.api.append(this.form)
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
    },
    querySearch(queryString, callback) {
      const { modules } = this.$store.state.api.formProps
      const results = queryString ? modules.filter(this.createFilter(queryString)) : modules
      callback(results)
    },
    handleSelect() {},
    createFilter(queryString) {
      return (icon) => (icon.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0)
    }
  }
}
</script>

<style scoped>

</style>
