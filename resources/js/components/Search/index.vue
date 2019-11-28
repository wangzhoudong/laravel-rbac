<template>
  <div>
    <el-divider content-position="left" @click="onClickSearchType">{{ typeArr[searchType] }}</el-divider>
    <el-row v-if="searchType=='simple'">
      <el-col :span="24">

        <el-form :inline="true" class="demo-form-inline">
          <el-form-item label="">
            <el-select v-model="select" placeholder="请选择" @change="onClickQueryItems">
              <el-option
                v-for="(queryItem,index) in queryItems"
                :key="index"
                :label="queryItem.displayName"
                :value="queryItem.field"
              />
            </el-select>
          </el-form-item>
          <el-form-item label="">

            <el-input
              v-if="!currentQueryItems.field.endsWith('Time') && (!currentQueryItems.type || !currentQueryItems.type === 'checkbox' || !currentQueryItems.type === 'select' || !currentQueryItems.type === 'interval')"
              v-model="currentQueryItems.value"
              :placeholder="'请输入'+(currentQueryItems.displayName?currentQueryItems.displayName:'')"
            />

            <el-select v-if="currentQueryItems.type == 'select'" v-model="currentQueryItems.value" placeholder="请选择">
              <el-option
                v-for="(item,curIndex) in currentQueryItems.selectOptions"
                :key="curIndex"
                :label="item.name"
                :value="item.value"
              />
            </el-select>

            <el-checkbox-group v-if="currentQueryItems.type == 'checkbox'" v-model="currentQueryItems.value">
              <el-checkbox
                v-for="(item,curIndex) in currentQueryItems.selectOptions"
                :key="curIndex"
                :label="item.name"
                :value="item.value"
              />
            </el-checkbox-group>

            <el-date-picker
              v-if="currentQueryItems.field.endsWith('Time') && (!currentQueryItems.type || !currentQueryItems.type === 'select' || !currentQueryItems.type === 'orderStatusSelect')"
              v-model="currentQueryItems.value"
              :editable="false"
              type="datetimerange"
              range-separator="至"
              start-placeholder="开始日期"
              end-placeholder="结束日期"
              align="right"
            />

          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="onSubmit">查询</el-button>
          </el-form-item>
        </el-form>

      </el-col>
    </el-row>
    <el-row v-if="searchType=='complex'">
      <el-col :span="24">
        <el-form :inline="true" class="demo-form-inline">
          <el-form-item
            v-for="(queryItem,index) in queryItems"
            :key="index"
            :label="queryItem.displayName?queryItem.displayName:''"
          >
            <el-input
              v-if="!queryItem.field.endsWith('Time') && (!queryItem.type || !queryItem.type === 'checkbox' || !queryItem.type === 'select' || !queryItem.type === 'interval')"
              v-model="queryItem.value"
              :placeholder="'请输入'+(queryItem.displayName?queryItem.displayName:'')"
            />

            <el-select v-if="queryItem.type == 'select'" v-model="queryItem.value" placeholder="请选择">
              <el-option
                v-for="(item,curIndex) in queryItem.selectOptions"
                :key="curIndex"
                :label="item.name"
                :value="item.value"
              />
            </el-select>

            <el-checkbox-group v-if="queryItem.type == 'checkbox'" v-model="queryItem.value">
              <el-checkbox
                v-for="(item,curIndex) in queryItem.selectOptions"
                :key="curIndex"
                :label="item.name"
                :value="item.value"
              />
            </el-checkbox-group>

            <el-date-picker
              v-if="queryItem.field.endsWith('Time') && (!queryItem.type || !queryItem.type === 'select' || !queryItem.type === 'orderStatusSelect')"
              v-model="queryItem.value"
              :editable="false"
              type="datetimerange"
              range-separator="至"
              start-placeholder="开始日期"
              end-placeholder="结束日期"
              align="right"
            />

          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="onSubmit">查询</el-button>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import Lang from '@/utils/lang'
import { each } from '@/utils/util'

export default {
  name: 'Search',
  props: {
    queryItems: {
      type: Object
    }
  },
  data() {
    return {
      searchType: 'simple',
      select: '',
      currentQueryItems: {
        field: '',
        value: null
      },
      typeArr: {
        simple: '简单查询',
        complex: '复杂查询'
      }
    }
  },
  methods: {
    onSubmit(e) {
      const $param = {}
      if (this.searchType === 'simple') {
        if (Lang.isEmpty(this.currentQueryItems.value)) {
          return
        }
        $param[this.currentQueryItems.field] = this.currentQueryItems.value
      } else {
        each(this.queryItems, (queryItem) => {
          if (Lang.isEmpty(queryItem.value)) {
            return
          }
          $param[queryItem.field] = queryItem.value
        })
      }
      this.$emit('search-query', { type: 'search', search: $param })
    },
    onClickQueryItems(type) {
      this.currentQueryItems = this.queryItems[type] || {}
    },
    onClickSearchType(e) {
      if (this.searchType === 'simple') {
        this.searchType = 'complex'
      } else if (this.searchType === 'complex') {
        this.searchType = 'simple'
      }
    }
  }
}
</script>

<style scoped>

</style>
