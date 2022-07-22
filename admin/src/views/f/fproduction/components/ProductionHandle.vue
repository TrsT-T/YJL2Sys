<!--
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-04 17:05:26
 * @LastEditTime: 2022-07-12 11:46:49
 * @Description: 
-->
<template>
  <div class="project">
    <!-- 查询栏 -->
    <div>
      <el-input v-model="listQuery.PLAN_NO" placeholder="请输入计划号" style="width: 200px;" class="filter-item" clearable
        @change="handleFilter" />
      <el-input v-model="listQuery.IN_MAT_NO" placeholder="请输入入口卷号" style="width: 200px;" class="filter-item" clearable
        @change="handleFilter" />
      <el-input v-model="listQuery.OUT_MAT_NO" placeholder="请输入出口钢卷号" style="width: 200px;" class="filter-item"
        clearable @change="handleFilter" />
      <s-date-picker :date="listQuery.created_at" startPlaceholder="钢卷完成开始时间" endPlaceholder="钢卷完成结束时间"
        class="filter-date" @changeDateTime="eventStartTime"></s-date-picker>
    </div>
    <!-- 按钮 -->
    <div class="project-button">
      <el-button v-waves plain class="filter-item" type="info" icon="fa fa-refresh" @click="refresh">
        刷新
      </el-button>
      <el-button v-waves plain class="filter-item" type="danger" :disabled="multipleSelection.length === 0"
        icon="el-icon-delete" @click="planDestroyAll">
        删除
      </el-button>
    </div>
    <!-- 计划表 -->
    <el-table v-loading="listLoading" height="300" :data="list" style="width: 100%"
      @selection-change="handleSelectionChange">
      <el-table-column fixed type="selection" align="center" width="30px"></el-table-column>
      <el-table-column fixed align="center" label="编号" width="80px">
        <template slot-scope="scope">
          <span>{{ (listQuery.page - 1) * listQuery.limit + scope.$index + 1 }}</span>
        </template>
      </el-table-column>
      <el-table-column fixed width="150px" align="center" label="计划号">
        <template slot-scope="{row}">
          <span>{{ row.PLAN_NO }}</span>
        </template>
      </el-table-column>
      <el-table-column fixed width="150px" align="center" label="入口卷号">
        <template slot-scope="{row}">
          <span>{{ row.IN_MAT_NO }}</span>
        </template>
      </el-table-column>
      <el-table-column fixed width="150px" align="center" label="出口卷号">
        <template slot-scope="{row}">
          <span>{{ row.OUT_MAT_NO }}</span>
        </template>
      </el-table-column>
      <el-table-column width="150px" align="center" label="生产开始时间">
        <template slot-scope="{row}">
          <span>{{ row.created_at }}</span>
        </template>
      </el-table-column>
      <el-table-column width="150px" align="center" label="生成结束时间">
        <template slot-scope="{row}">
          <span>{{ row.updated_at }}</span>
        </template>
      </el-table-column>
    </el-table>
    <!-- 页码 -->
    <pagination v-show="total > 0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit"
      @pagination="getList" />
    <el-dialog title="请求详情" :visible.sync="dialogVisible" width="80%" @close="dialogClose">
      <el-form label-width="100px">
        <el-form-item label="请求参数">
          <json-editor ref="jsonEditor" v-model="info.data" />
        </el-form-item>
        <el-form-item label="header头信息">
          <json-editor ref="jsonEditor" v-model="info.header" />
        </el-form-item>
      </el-form>
    </el-dialog>
  </div>
</template>

<script>
import { getFProductionList, delFProductionAll } from '@/api/f/production'
import JsonEditor from '@/components/JsonEditor'
export default {
  name: 'ProductionHandle',
  components: { JsonEditor },
  data() {
    return {
      list: [],
      total: 0,
      listLoading: true,//显示缓冲状态
      downloadLoading: false,
      dialogVisible: false,//页码显示状态
      listQuery: {
        page: 1,
        limit: 10,
        PLAN_NO: null,
        IN_MAT_NO: null,
        OUT_MAT_NO: null,
        created_at: [],
        updated_at: []
      },
      multipleSelection: [],
      info: {
        data: {},
        header: {}
      },
      typeList: {
        'GET': 'primary',
        'POST': 'success',
        'PUT': 'warning',
        'DELETE': 'danger'
      },
    }
  },
  async created() {
    await this.getList()
  },
  methods: {
    handleSelectionChange(val) {
      this.multipleSelection = val
    },
    eventStartTime(val) {
      this.listQuery.created_at = val
      this.handleFilter()
    },
    // 获取表格列表
    async getList() {
      this.listLoading = true
      getFProductionList(this.listQuery).then(response => {
        if (response.status === 20000) {
          this.list = response.data.list
          this.total = response.data.total
        }
        this.listLoading = false
      })
    },
    // 监听修改密码对话框的关闭事件
    editAdminDialogClose() {
      this.$refs.editAdminRef.resetFields();
    },
    // 搜索
    handleFilter() {
      this.listQuery.page = 1
      this.getList()
    },
    // 刷新
    refresh() {
      this.listQuery = {
        page: 1,
        limit: 10,
        PLAN_NO: null,
        IN_MAT_NO: null,
        OUT_MAT_NO: null,
        created_at: [],
        updated_at: []
      }
      this.getList()
    },
    //删除
    planDestroyAll() {
      if (this.multipleSelection.length <= 0) {
        this.$base.message({ message: '请选择需要删除的选项！' })
        return
      }
      const idArr = this.multipleSelection.map((item, index) => { return item.id })
      this.$base.confirm(
        { content: "确定要删除所选项吗！" },
        () => {
          delFProductionAll({ idArr: idArr }).then(response => {
            if (response.status === 20000) {
              this.$base.message({ message: response.message })
              this.getList()
            }
          })
        }
      )
    },
    getinfo(info) {
      this.dialogVisible = true
      info.data = JSON.parse(info.data)
      info.header = JSON.parse(info.header)
      this.info = info
    },
    // 监听添加编辑对话框的关闭事件
    dialogClose() {
      this.info = {
        data: "",
        header: ""
      }
    }
  }
}
</script>

<style>
.project {
  margin: 10px;
}

.filter-item {
  padding-left: 5px;
  padding-top: 5px;
  float: left;
}

.filter-date {
  padding: 10px 0px 0px 5px;
}

.project-button {
  margin: -10px 10px 30px 5px;
}
</style>
</style>