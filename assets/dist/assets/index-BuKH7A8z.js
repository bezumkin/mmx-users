import{o as y}from"./vesp-3mqwPoPx.js";import{s as h}from"./vue-bootstrap-DqOMAocd.js";import{a as A}from"./vue-router-a3flUsTq.js";import{c as e}from"./api-C4uRSHIu.js";import{d as v,A as t,z as l,g as w,o,c as m,u as r,b as B,w as n,q as d,e as T,f as V,m as C}from"./vue-COS8aM9k.js";const L=["innerHTML"],M="rank",N="desc",R="mgr-user-group-users",S=v({__name:"index",setup(q){const{params:a}=A(),c=t(()=>"mgr/user-group/"+a.id+"/users"),i=l(),p=t(()=>[{route:{name:"groups-id-index-users-index-uid",params:{uid:0}},icon:"plus",title:e("models.user.title_one")}]),_=t(()=>[{key:"user",label:e("models.user_group_member.member")},{key:"role.name",label:e("models.user_group_member.role")},{key:"rank",label:e("models.user_group_member.rank"),sortable:!0}]),f=t(()=>{var s;return[{route:{name:"groups-id-index-users-index-uid"},map:{id:"user_group",uid:"id"},icon:"edit",title:e("actions.edit")},{function:(s=i.value)==null?void 0:s.delete,icon:"times",title:e("actions.delete"),variant:"danger"}]}),b=l({query:""});return(s,H)=>{const g=h,k=w("RouterView"),x=y;return o(),m("div",null,[Number(r(a).id)?(o(),B(x,C({key:1,ref_key:"table",ref:i},{url:r(c),fields:r(_),headerActions:r(p),tableActions:r(f),filters:r(b),sort:M,dir:N,updateKey:R}),{"cell(user)":n(({value:u})=>[d(g,{to:{name:"index-user",params:{user:u.id}}},{default:n(()=>[T(V(u.username),1)]),_:2},1032,["to"])]),default:n(()=>[d(k)]),_:1},16)):(o(),m("div",{key:0,class:"alert alert-info",innerHTML:s.$t("models.user_group.tabs.users.disabled")},null,8,L))])}}});export{S as default};
