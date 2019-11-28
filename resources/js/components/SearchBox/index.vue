<template>
  <div class="filter-container">
    <div v-for="(item, index) in searchList" :key="index">
      <el-input v-if="item.type === 'input'" v-model="item.value" :placeholder="item.label" class="filter-item normal-width" size="mini" />
      <el-select v-if="item.type === 'select'" v-model="item.value" :placeholder="'请选择' + item.label" class="filter-item normal-width" size="mini">
        <el-option
          v-for="option in item.options"
          :key="option.value"
          :label="option.label"
          :value="option.value"
        />
      </el-select>
      <el-date-picker
        v-if="item.type === 'datetime'"
        v-model="item.value"
        type="datetime"
        :placeholder="'选择' + item.label"
        class="filter-item time-width"
        size="mini"
      />
      <el-date-picker
        v-if="item.type === 'datetimerange'"
        v-model="item.value"
        type="datetimerange"
        range-separator="-"
        :start-placeholder="item.label + '开始日期'"
        :end-placeholder="item.label + '结束日期'"
        size="mini"
        style="margin-right: 10px"
      />
    </div>
    <el-button size="mini" class="filter-item" icon="el-icon-search" @click="search" />
  </div>
</template>

<script>
import { parseTime } from '@/utils/index'

export default {
  name: 'SearchBox',
  props: {
    list: {
      type: Array,
      required: true
    },
    callback: {
      type: Function,
      required: true
    }
  },
  data() {
    return {
      searchList: []
    }
  },
  mounted() {
    // 检查一下数据结构
    console.log(this.list)
    this.list.forEach(item => {
      if (!item.hasOwnProperty('key') || !item.hasOwnProperty('type') || !item.hasOwnProperty('label') || !item.hasOwnProperty('value')) {
        throw new Error('传入的数据结构有问题')
      }
      if (item.type === 'select' && !item.options) {
        throw new Error('传入的类型为"select"时，必须有options参数')
      }
    })
    this.searchList = this.list
  },
  methods: {
    search() {
      const params = {}
      // 处理每个项的值
      this.searchList.forEach(item => {
        // 如果是时间的话，就把时间对象转化为时间字符串
        switch (item.type) {
          case 'datetime':
            if (item.value) {
              item.value = parseTime(item.value)
            }
            break
          case 'datetimerange':
            if (item.value) {
              item.value = [
                parseTime(item.value[0]),
                parseTime(item.value[1])
              ]
            } else {
              item.value = []
            }
            break
        }
        params[item.key] = item.value
      })
      this.callback(params)
    }
  }
}
</script>

<style scoped>

.filter-container {
  padding-bottom: 10px;
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-start;
}

.filter-container .filter-item {
  margin-bottom: 10px;
  margin-right: 10px;
}

.normal-width {
  width: 150px;
}

.time-width {
  width: 170px;
}
</style>
