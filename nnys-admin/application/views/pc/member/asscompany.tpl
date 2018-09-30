  <link rel="stylesheet" href="{views:css/company.css}" />
    <div id="content" class="white">
    	<h1><img src="/nn2/nnys-admin/views/pc/img/icons/posts.png" alt=""> 关联账号审核</h1>
        <div class="bloc">
            <div class="title">
                 企业关联账号审核列表
            </div>
            <div class="mt-20 companyTable">
                <div class="asscompanyInfo" v-for="(items,m) in companyList" v-if="items.values!=''">
                    <div class="companyName">{{items.companyName}}</div>
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <tr class="text-c">
                            <th>序号</th>
                            <th>关联账号</th>
                            <th>姓名</th>
                            <th>联系方式</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        <tr class="text-c" v-for="(listValue,index) in items.values" v-show="index < items.count">
                            <td v-if="index<9">0{{index+1}}</td>
                            <td v-else>{{index+1}}</td>
                            <td>{{listValue.account}}</td>
                            <td>{{listValue.uername}}</td>
                            <td>{{listValue.tel}}</td>
                            <td>
                                <span v-if="listValue.state == 0" class="">待审核</span>
                                 <span v-if="listValue.state == 1" class="yesadopt">已通过</span>
                                <span v-if="listValue.state == 2" class="noadopt">未通过</span>
                            </td>
                            <td class="done" v-if="listValue.state ==0">
                                <a data-num='1' class="cur" @click="stateSel($event,m,index)">同意</span>
                                <a data-num='2' class="cur" @click="stateSel($event,m,index)">不同意</span>
                            </td>
                            <td class="done" v-if="listValue.state ==1">
                                <a title="已审核" class="cur yesCur">同意</span>
                                <a title="已审核" class="cur">不同意</span>
                            </td>
                            <td class="done" v-if="listValue.state ==2">
                                <a title="已审核" class="cur">同意</span>
                                <a title="已审核" class="cur noCur">不同意</span>
                            </td>
                        </tr>
                    </table>
                    <div class="moreInfo" v-if="items.values.length>3">
                        <div v-if="items.values.length>count"  @click="more(m)">
                            <i class="moreIcon fa fa-plus-circle"></i>
                            <div>显示更多</div>
                        </div>
                        <div v-else  @click="reduce(m)">
                            <i class="moreIcon fa fa-minus-circle"></i>
                            <div>收起</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="upIcon" @click="toTop()">
            <img src="{views:images/upIcon.png}"/>
            <div class="uptitle">回到顶部</div>
        </div>
    </div>
<script type="text/javascript" src="{views:js/vue.min.js}"></script>
<script type="text/javascript" src="{views:js/axios.min.js}"></script>
<script>
new Vue({
    el:'#content',
    data(){
      return {
        companyList:[
           /* {
                companyName:"企业1",
                values:[
                   
                  ]
            },
              {
                companyName:"企业2",
                values:[
                    {
                        account:"1-fei1234",
                        uername:"张三",
                        tel:"13209387623",
                        state:0,//state状态，0待审核，1同意，2不同意
                    },
                    {
                        account:"2-fei1234",
                        uername:"张三",
                        tel:"13209387623",
                        state:1,//state状态，0待审核，1同意，2不同意
                    },
                    {
                        account:"3-fei1234",
                        uername:"张三",
                        tel:"13209387623",
                        state:2,//state状态，0待审核，1同意，2不同意
                    },
                    {
                        account:"4-fei1234",
                        uername:"张三",
                        tel:"13209387623",
                        state:1,//state状态，0待审核，1同意，2不同意
                    },
                    {
                        account:"4-fei1234",
                        uername:"张三",
                        tel:"13209387623",
                        state:1,//state状态，0待审核，1同意，2不同意
                    },
                    {
                        account:"4-fei1234",
                        uername:"张三",
                        tel:"13209387623",
                        state:1,//state状态，0待审核，1同意，2不同意
                    },
                    {
                        account:"4-fei1234",
                        uername:"张三",
                        tel:"13209387623",
                        state:1,//state状态，0待审核，1同意，2不同意
                    },
                    {
                        account:"4-fei1234",
                        uername:"张三",
                        tel:"13209387623",
                        state:1,//state状态，0待审核，1同意，2不同意
                    },
                    {
                        account:"4-fei1234",
                        uername:"张三",
                        tel:"13209387623",
                        state:1,//state状态，0待审核，1同意，2不同意
                    },
                    {
                        account:"4-fei1234",
                        uername:"张三",
                        tel:"13209387623",
                        state:1,//state状态，0待审核，1同意，2不同意
                    },
                    {
                        account:"4-fei1234",
                        uername:"张三",
                        tel:"13209387623",
                        state:1,//state状态，0待审核，1同意，2不同意
                    },

                  ]
            },*/

        ],//企业数据
        count:3,
        url:"http://rap2api.taobao.org/app/mock/24754"
      }
    },
    created(){
     this.pingData()
    },
    methods:{

    //显示数量
    pingData(){
        var that= this;
        axios({
            method: 'get',
            url: this.url+'/asscompany/list',
            params:{
                
            }
        }).then(function(res){
            var companyData=res.data.companyList
            for(var i=0;i<companyData.length;i++){
                companyData[i]["count"] = that.count
                //this.$set((companyData[i],"count", "3")
            }
            that.companyList = companyData
            console.log("companyList:", that.companyList)
        })
    },

     //加载更多
      more(idx) {
       console.log("dd",this.companyList[idx].values.length,)
        if(this.companyList[idx].values.length > this.count){
          this.count+=3
          this.companyList[idx].count= this.count
        }else{
          this.companyList[idx].count = this.companyList[idx].values.length
        }
          console.log("num",this.companyList)
      },
       //收起
      reduce(rdx){
        this.companyList[rdx].count = 3
        console.log("d",this.companyList[rdx])
        this.count=3
      },
      //收起end
      //回到顶部
        toTop() {
            document.documentElement.scrollTop = document.body.scrollTop = 0;
        },
        //同意不同意选择审核结果
        stateSel(e,fm,idex){
           this.companyList[fm].values[idex].state = e.target.getAttribute('data-num')
             console.log(e.target.getAttribute('data-num'))
        }
    }
})</script>