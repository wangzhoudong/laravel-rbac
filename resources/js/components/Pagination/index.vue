<template>
  <div class="pagination">
    <el-pagination
      :current-page="this.list.current_page"
      :page-sizes="[10, 30, 50, 100]"
      :page-size="parseInt(this.list.per_page)"
      layout="total, sizes, prev, pager, next, jumper"
      :total="this.list.total"
      :small="true"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
    />
  </div>
</template>

<script>
import { deepClone } from '@/utils/util'

export default {
  name: 'Pagination',
  props: {
    queryData: {
      type: Object
    },
    list: {
      type: Object,
      required: true
    },
    action: {
      type: String,
      required: true
    },
    params: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  data() {
    return {
      innerParams: this.params
    }
  },
  watch: {
    list(val) {
      val.current_page = parseInt(val.current_page)
      val.per_page = parseInt(val.per_page)
      val.total = parseInt(val.total)
    }
  },
  methods: {
    handleSizeChange(val) {
      const action = this.action
      this.innerParams = { page: 1, limit: val }
      this.__dispatchAction(action)
    },
    handleCurrentChange(val) {
      const action = this.action
      this.innerParams.page = val
      this.__dispatchAction(action)
    },
    __dispatchAction(action) {
      const queryData = deepClone(this.queryData) || {}
      const query = Object.assign(deepClone(queryData.pagination || {}), deepClone(queryData.search || {}), this.innerParams)
      this.$store.dispatch(action, query)
    }
  }
}
</script>

<style scoped>
  .pagination {
    margin-top: 10px;
  }
</style>
