  <link rel="stylesheet" href="{views:css/company.css}" />
    <div id="content" class="white">
    	<h1><img src="/nn2/nnys-admin/views/pc/img/icons/posts.png" alt=""> 新增企业及列表</h1>
        <div class="bloc">
            <div class="title">
                 新增企业
            </div>
            <div class="pd-20">
            	<div class="companyInfo">
            		<!-- 增加企业接口 -->
            		<form @submit.prevent="submit">
            		<div class="companyInput">
            			<span class="infoTitle"></span>
            			<span class="tip">{{companyTip}}</span>
            		</div>
            		<div class="companyInput">
            			<span class="infoTitle">企业名称：</span>
            			<input class="infoText" type="text" name="companyName"  v-model="inputtext.companyName" @change="companynameJud()">
            		</div>
            		<div class="companyInput">
            			<span class="infoTitle">企业logo：</span>
            			<input class="infoText" type="text" placeholder="选一个字做logo"  v-model="inputtext.companyLogo" @change="logoJud()">
            			<span class="infoTip">(必须为企业名称中的字)</span>
            		</div>
            		<div class="companyInput">
            			<span class="infoTitle">企业等级：</span>
            			<input class="infoText" type="text" @change="gradeJud()"  v-model="inputtext.companyCredit">
            			<span class="infoTip">(等级按1-5级划分)</span>
            		</div>
            		<div class="companyInput">
            			<span class="infoTitle">联系人：</span>
            			<input class="infoText" type="text"  v-model="inputtext.contact">
            		</div>
            		<div class="companyInput">
            			<span class="infoTitle">联系方式：</span>
            			<input class="infoText" type="text"  @change="phoneJud()" v-model="inputtext.contactPhone">
            		</div>
            		<div class="companyInput">
            			<span class="infoTitle"></span>
            			<input class="infoBtn" type="submit" value="确定提交">
            		</div>
            		</form>
            	</div>
            </div>
            <div class="title">
                 企业列表结果
            </div>
           <div class="mt-20 companyTable">
				<table class="table table-border table-bordered table-hover table-bg table-sort">
             		<tr class="text-c">
             			<th>企业名称</th>
             			<th>联系人</th>
             			<th>联系方式</th>
             			<th>企业简称</th>
             			<th>企业等级</th>
             		</tr>
             		<tr v-for="(companyList,index) in companyLists">
             			<td>{{companyList.companyName}}</td>
             			<td>{{companyList.contact}}</td>
             			<td>{{companyList.contactPhone}}</td>
             			<td>{{companyList.companyLogo}}</td>
             			<td>{{companyList.companyCredit}}</td>
             		</tr>
             	</table>
             	<div class="pages_bar">
             		<a v-on:click="curPages(1)">首页</a>
             		<a v-for="index in allpage" v-bind:class="{ 'current_page': curpage == index}" v-on:click="curPages(index)">{{index}}</a>
             		<a v-on:click="curPages(allpage)">尾页</a>
             		<span>当前第{{curpage}}页/共{{allpage}}页</span>
             	</div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="{views:js/vue.min.js}"></script>
<script type="text/javascript" src="{views:js/axios.min.js}"></script>
<script>
new Vue({
    el:'#content',
    data(){
      return {
        inputtext:{},//表单内容
        curpage:1,//当前页码
        allpage:1,//总页面数
        url:'http://192.168.13.119:8081',
        companyTip:"",
        companyLists:{}//公司信息列表
      }
    },
    created(){
    	this.companyList(1)
    },
    methods:{
    	/*各部分内容验证
    	*companynameJud 公司名称验证
    	*logoJud 公司logo验证
    	*gradeJud 公司等级验证
    	*phoneJud 手机号验证*/
    	companynameJud(){
    		var companyName = this.inputtext.companyName//获取企业名称
    		console.log(companyName)
    		if(companyName==""){
    			this.companyTip="公司名称不能为空"
    		}else{
            	 this.companyTip=""
            }
    	},
    	logoJud(){
            var companyName = this.inputtext.companyName
            var companyLogo = this.inputtext.companyLogo
            if(companyName.indexOf(companyLogo) == -1 || companyLogo.length>1){
               this.companyTip="请输入企业名字中的某一个字"
            }else{
            	 this.companyTip=""
            }
        },
    	gradeJud(){
    		var companyCredit = this.inputtext.companyCredit//获取等级内容
			var reg=/^[0-9]+.?[0-9]*$/; //判断字符串是否为数字 ，判断正整数用/^[1-9]+[0-9]*]*$/
			//判断等级是否输入的是1-5的数字
			if(!reg.test(companyCredit)||companyCredit>5){
				this.companyTip="请输入1-5的数字"
			}else{
            	 this.companyTip=""
            }
    	},
    	phoneJud(){
    		var myreg=/^[1][3,4,5,7,8][0-9]{9}$/;//11位手机号正则表达式
    		var contactPhone = this.inputtext.contactPhone//联系方式
    		if(!myreg.test(contactPhone)){
				this.companyTip="请输入正确的手机号"
			}else{
				this.companyTip=""
			}
    	},
    	//提交增加的企业信息
    	submit: function() {
    		var companyName = this.inputtext.companyName
    		var contact = this.inputtext.contact
    		var contactPhone = this.inputtext.contactPhone
    		var companyCredit = this.inputtext.companyCredit
    		var companyLogo = this.inputtext.companyLogo
    		this.companyTip=""
    		console.log(companyName,contact,contactPhone,companyCredit,companyLogo)
    		if(companyName!=undefined&&contact!=undefined&&contactPhone!=undefined&&companyCredit!=undefined&&companyLogo!=undefined){
    			axios({
			        method: 'post',
			        url:this.url+'/userCompany/addCompany',
			        data:this.inputtext,
			    }).then(function(res){
			        console.log(res.data.message)
			    }).catch(function (res) {
			    	console.log("错误返回信息",res)
			    })
			    this.companyList(1)
    		}else{
    			this.companyTip="以下信息不能为空"
    		}
    		
		},
		companyList(num){
			var that =this
			axios({
		        method: 'get',
		        //url:this.addcompanyUrl,
		        url:that.url+'/userCompany/companys',
		        params:{
		        	page:num,
		        	pagesize:20
		        }
		    }).then(function(info){
		    	if(info.data.data!=null){
		    		that.allpage=info.data.data.pageCount
			        that.companyLists=info.data.data.userCompany
			        console.log("公司列表信息",that.allpage,"列表：",that.companyLists)
		    	}
		    }).catch(function (info) {
		    	console.log("错误返回信息",info)
		    })
		},
		curPages(pages){
			this.curpage=pages
			this.companyList(pages)
			console.log(pages)
		}
	
	}
})</script>