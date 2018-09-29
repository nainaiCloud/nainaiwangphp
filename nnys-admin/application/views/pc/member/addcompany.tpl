  <link rel="stylesheet" href="{views:css/company.css}" />
    <div id="content" class="white">
    	<h1><img src="/nn2/nnys-admin/views/pc/img/icons/posts.png" alt=""> 新增企业及列表</h1>
        <div class="bloc">
            <div class="title">
                 新增企业
            </div>
            <div class="pd-20">
            	<div class="companyInfo">
            		<form @submit.prevent="submit">
            		<div class="companyInput">
            			<span class="infoTitle">企业名称：</span>
            			<input class="infoText" type="text" name="companyName"  v-model="inputtext.companyName">
            		</div>
            		<div class="companyInput">
            			<span class="infoTitle">企业logo：</span>
            			<input class="infoText" type="text" placeholder="选一个字做logo"  v-model="inputtext.companyLogo">
            			<span class="infoTip">(必须为企业名称中的字)</span>
            		</div>
            		<div class="companyInput">
            			<span class="infoTitle">企业等级：</span>
            			<input class="infoText" type="text"  v-model="inputtext.companyGrade">
            			<span class="infoTip">(等级按1-5级划分)</span>
            		</div>
            		<div class="companyInput">
            			<span class="infoTitle">联系人：</span>
            			<input class="infoText" type="text"  v-model="inputtext.contacts">
            		</div>
            		<div class="companyInput">
            			<span class="infoTitle">联系方式：</span>
            			<input class="infoText" type="text"  v-model="inputtext.phone">
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
             		<tr >
             			<td></td>
             			<td></td>
             			<td></td>
             			<td></td>
             			<td></td>
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
        allpage:10,//总页面数

      }
    },
    created(){
    },
    methods:{
    	submit: function() {
			console.log(this.inputtext);
		},
		curPages(pages){
			this.curpage=pages
			console.log(pages)
		}
	
	}
})</script>