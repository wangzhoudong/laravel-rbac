<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!-- import CSS -->
    <link href="https://cdn.bootcss.com/element-ui/2.12.0/theme-chalk/index.css" rel="stylesheet">
</head>
<body>
<div id="app">
    <template>
        <el-table
            :data="tableData"
            style="width: 100%">
            <el-table-column
                prop="date"
                label="日期"
                width="180">
            </el-table-column>
            <el-table-column
                prop="name"
                label="姓名"
                width="180">
            </el-table-column>
            <el-table-column
                prop="address"
                label="地址">
            </el-table-column>
        </el-table>
    </template>

</div>
</body>
<script src="https://cdn.bootcss.com/vue/2.6.10/vue.min.js"></script>
<script src="https://cdn.bootcss.com/element-ui/2.12.0/index.js"></script>
<script src="https://cdn.bootcss.com/axios/0.19.0/axios.min.js"></script>

<script>

  new Vue({
    el: '#app',
    created:function() {
      // Make a request for a user with a given ID
      axios.get('/rbac/api/menu')
        .then(function (response) {
          // handle success
          console.log(response);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
        .then(function () {
          // always executed
        });

    },
    data: function() {
      return {

      }
    }
  })

</script>
</html>
