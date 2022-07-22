<!--
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-04 17:05:26
 * @LastEditTime: 2022-07-11 16:29:46
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
      <s-date-picker :date="listQuery.created_at" startPlaceholder="计划下发开始时间" endPlaceholder="计划下发结束时间"
        class="filter-date" @changeDateTime="eventStartTime"></s-date-picker>
    </div>
    <!-- 按钮 -->
    <div class="project-button">
      <el-button v-waves plain class="filter-item" type="info" icon="fa fa-refresh" @click="refresh">
        刷新
      </el-button>
      <el-button v-waves plain class="filter-item" type="success" icon="el-icon-circle-plus-outline"
        @click.native="editFPlanVisible = true">
        新建
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
      <el-table-column fixed width="100px" align="center" label="计划号">
        <template slot-scope="{row}">
          <span>{{ row.PLAN_NO }}</span>
        </template>
      </el-table-column>
      <el-table-column fixed width="100px" align="center" label="入口卷号">
        <template slot-scope="{row}">
          <span>{{ row.IN_MAT_NO }}</span>
        </template>
      </el-table-column>
      <el-table-column fixed width="100px" align="center" label="出口卷号">
        <template slot-scope="{row}">
          <span>{{ row.OUT_MAT_NO }}</span>
        </template>
      </el-table-column>
      <el-table-column width="100px" align="center" label="覆膜种类">
        <template slot-scope="{row}">
          <span>{{ row.FILM_KIND_CODE }}</span>
        </template>
      </el-table-column>
      <el-table-column width="100px" align="center" label="钢卷钢种">
        <template slot-scope="{row}">
          <span>{{ row.SG_SIGN }}</span>
        </template>
      </el-table-column>
      <el-table-column width="120px" align="center" label="入口钢卷厚度">
        <template slot-scope="{row}">
          <span>{{ row.IN_MAT_THICK }}</span>
        </template>
      </el-table-column>
      <el-table-column width="120px" align="center" label="入口钢卷宽度">
        <template slot-scope="{row}">
          <span>{{ row.IN_MAT_WIDTH }}</span>
        </template>
      </el-table-column>
      <el-table-column width="120px" align="center" label="入口钢卷重量">
        <template slot-scope="{row}">
          <span>{{ row.IN_MAT_WT }}</span>
        </template>
      </el-table-column>
      <el-table-column width="120px" align="center" label="入口钢卷长度">
        <template slot-scope="{row}">
          <span>{{ row.IN_MAT_LEN }}</span>
        </template>
      </el-table-column>
      <el-table-column width="120px" align="center" label="入口钢卷内径">
        <template slot-scope="{row}">
          <span>{{ row.IN_MAT_IN_DIA }}</span>
        </template>
      </el-table-column>
      <el-table-column width="120px" align="center" label="入口钢卷外径">
        <template slot-scope="{row}">
          <span>{{ row.IN_MAT_DIA }}</span>
        </template>
      </el-table-column>
      <el-table-column width="100px" align="center" label="最终卷标记">
        <template slot-scope="{row}">
          <span>{{ row.FINAL_COIL_FLAG }}</span>
        </template>
      </el-table-column>
      <el-table-column fixed="right" label="操作" align="center" width="100px" class-name="small-padding fixed-width">
        <template slot-scope="{row}">
          <el-button v-waves size="mini" type="primary" @click="planStart(row.id, row.IN_MAT_NO, row.OUT_MAT_NO)">
            开卷
          </el-button>
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
    <!-- 新建计划 -->
    <el-dialog title="新建计划" append-to-body :visible.sync="editFPlanVisible" width="60%" @close="editAdminDialogClose">
      <el-form label-width="130px" :model="editFPlanForm" :rules="editFPlanRules" ref="editAdminRef">
        <el-form-item label="入口钢卷号" prop="IN_MAT_NO">
          <el-input v-model="editFPlanForm.IN_MAT_NO"></el-input>
        </el-form-item>
        <el-form-item label="出口钢卷号" prop="OUT_MAT_NO">
          <el-input v-model="editFPlanForm.OUT_MAT_NO"></el-input>
        </el-form-item>
        <el-form-item label="入口钢卷厚度" prop="IN_MAT_THICK">
          <el-input v-model="editFPlanForm.IN_MAT_THICK"></el-input>
        </el-form-item>
        <el-form-item label="入口钢卷宽度" prop="IN_MAT_WIDTH">
          <el-input v-model="editFPlanForm.IN_MAT_WIDTH"></el-input>
        </el-form-item>
        <el-form-item label="入口钢卷重量" prop="IN_MAT_WT">
          <el-input v-model="editFPlanForm.IN_MAT_WT"></el-input>
        </el-form-item>
        <el-form-item label="入口钢卷长度" prop="IN_MAT_LEN">
          <el-input v-model="editFPlanForm.IN_MAT_LEN"></el-input>
        </el-form-item>
        <el-form-item label="出口钢卷重量" prop="DIVIDE_WT">
          <el-input v-model="editFPlanForm.DIVIDE_WT"></el-input>
        </el-form-item>
        <el-form-item label="覆膜种类代码" prop="FILM_KIND_CODE">
          <el-input v-model="editFPlanForm.FILM_KIND_CODE"></el-input>
        </el-form-item>
      </el-form>
      <!-- 按钮区 -->
      <span slot="footer" class="dialog-footer">
        <el-button v-waves @click="editFPlanVisible = false">取 消</el-button>
        <el-button v-waves type="primary" @click="createPlan()">确 定</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import { getFPlanList, planStart, delFPlanAll, createPlan } from '@/api/f/plan'
import JsonEditor from '@/components/JsonEditor'
export default {
  name: 'PlanHandle',
  components: { JsonEditor },
  data() {
    var checkMatNo = (rule, value, callback) => {
      // 定义正则表达式
      const checkMatNo = /^[a-zA-Z0-9]{1,20}$/;
      if (checkMatNo.test(value)) {
        return callback();
      }
      callback(new Error("钢卷卷号必须1到20位的数字或字母!"));
    };
    var checkMatThick = (rule, value, callback) => {
      // 定义正则表达式
      const checkMatNo = /^[a-zA-Z0-9]{1,6}$/;
      if (checkMatNo.test(value)) {
        return callback();
      }
      callback(new Error("钢卷厚度必须1到6位的数字!"));
    };
    var checkMatWidth = (rule, value, callback) => {
      // 定义正则表达式
      const checkMatNo = /^[0-9]{1,7}$/;
      if (checkMatNo.test(value)) {
        return callback();
      }
      callback(new Error("钢卷宽度必须1到7位的数字!"));
    };
    var checkMatWt = (rule, value, callback) => {
      // 定义正则表达式
      const checkMatNo = /^[a-zA-Z0-9]{1,20}$/;
      if (checkMatNo.test(value)) {
        return callback();
      }
      callback(new Error("钢卷重量必须1到20位的数字!"));
    };
    var checkMaLen = (rule, value, callback) => {
      // 定义正则表达式
      const checkMatNo = /^[a-zA-Z0-9]{1,9}$/;
      if (checkMatNo.test(value)) {
        return callback();
      }
      callback(new Error("钢卷长度必须1到9位的数字!"));
    };
    var checkMatCode = (rule, value, callback) => {
      // 定义正则表达式
      const checkMatNo = /^[a-zA-Z0-9]{1,4}$/;
      if (checkMatNo.test(value)) {
        return callback();
      }
      callback(new Error("钢卷卷号必须1到4位的数字或字母!"));
    };
    return {
      list: [],
      total: 0,
      listLoading: true,//显示缓冲状态
      downloadLoading: false,
      dialogVisible: false,//页码显示状态
      editFPlanVisible: false,//新建页面显示状态
      listQuery: {
        page: 1,
        limit: 10,
        PLAN_NO: null,
        IN_MAT_NO: null,
        OUT_MAT_NO: null,
        created_at: []
      },
      editFPlanForm: {
        PLAN_NO: "",
        IN_MAT_NO: "",
        OUT_MAT_NO: "",
        IN_MAT_THICK: "",
        IN_MAT_WIDTH: "",
        IN_MAT_WT: "",
        IN_MAT_LEN: "",
        DIVIDE_WT: "",
        FILM_KIND_CODE: "",
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
      editFPlanRules: {
        IN_MAT_NO: [
          { required: true, message: "请输入入口卷号！", trigger: "blur" },
          { validator: checkMatNo, trigger: "blur" },
        ],
        OUT_MAT_NO: [
          { required: true, message: "请输入出口卷号！", trigger: "blur" },
          { validator: checkMatNo, trigger: "blur" },
        ],
        IN_MAT_THICK: [
          { required: true, message: "入口钢卷厚度！", trigger: "blur" },
          { validator: checkMatThick, trigger: "blur" },
        ],
        IN_MAT_WIDTH: [
          { required: true, message: "入口钢卷宽度！", trigger: "blur" },
          { validator: checkMatWidth, trigger: "blur" },
        ],
        IN_MAT_WT: [
          { required: true, message: "入口钢卷重量！", trigger: "blur" },
          { validator: checkMatWt, trigger: "blur" },
        ],
        IN_MAT_LEN: [
          { required: true, message: "入口钢卷长度！", trigger: "blur" },
          { validator: checkMaLen, trigger: "blur" },
        ],
        DIVIDE_WT: [
          { required: true, message: "出口钢卷重量！", trigger: "blur" },
          { validator: checkMatWt, trigger: "blur" },
        ],
        FILM_KIND_CODE: [
          { required: true, message: "覆膜种类代码！", trigger: "blur" },
          { validator: checkMatCode, trigger: "blur" },
        ],
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
      getFPlanList(this.listQuery).then(response => {
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
    // 新建计划
    createPlan() {
      createPlan(this.editFPlanForm).then((response) => {
        if (response.status === 20000) {
          this.$base.message({ message: response.message });
          this.editFPlanVisible = false;
          this.getList();
        }
      });
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
        method: null,
        PLAN_NO: null,
        IN_MAT_NO: null,
        OUT_MAT_NO: null,
        created_at: []
      }
      this.getList()
    },
    // 导出数据
    handleDownload() {
      this.downloadLoading = true
      import('@/vendor/Export2Excel').then(excel => {
        const tHeader = ['编号', '管理员', '操作描述', '操作路由', '请求方式', 'IP', '操作时间']
        const filterVal = ['id', 'admin_one', 'content', 'url', 'method', 'ip', 'created_at']
        const data = this.formatJson(filterVal)
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: this.$route.name
        })
        this.downloadLoading = false
      })
    },
    formatJson(filterVal) {
      return this.list.map(v => filterVal.map(j => {
        if (j === 'admin_one') {
          return v[j].username
        } else {
          return v[j]
        }
      }))
    },
    // 开卷
    planStart(id, inmatno, outmatno) {
      this.$base.confirm(
        { content: "确定开卷号:入口卷号为" + inmatno + "   出口卷号为：" + outmatno },
        () => {
          planStart({ id: id }).then(response => {
            if (response.status === 20000) {
              this.$base.message({ message: response.message })
              this.getList()
            }
          })
        }
      )
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
          delFPlanAll({ idArr: idArr }).then(response => {
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