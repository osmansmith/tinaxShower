"use strict";(()=>{var e={};e.id=717,e.ids=[717],e.modules={517:e=>{e.exports=require("next/dist/compiled/next-server/app-route.runtime.prod.js")},7703:(e,t,r)=>{r.r(t),r.d(t,{headerHooks:()=>m,originalPathname:()=>h,patchFetch:()=>g,requestAsyncStorage:()=>p,routeModule:()=>l,serverHooks:()=>c,staticGenerationAsyncStorage:()=>u,staticGenerationBailout:()=>d});var o={};r.r(o),r.d(o,{GET:()=>n});var a=r(5419),s=r(9108),i=r(9678);async function n(){let e="https://tinaxshower.com",t=new Date().toISOString(),r=`<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>${e}</loc>
    <lastmod>${t}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
  </url>
  <url>
    <loc>${e}/#services</loc>
    <lastmod>${t}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc>${e}/#gallery</loc>
    <lastmod>${t}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.7</priority>
  </url>
  <url>
    <loc>${e}/#contact</loc>
    <lastmod>${t}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
  </url>
</urlset>`;return new Response(r,{headers:{"Content-Type":"application/xml"}})}let l=new a.AppRouteRouteModule({definition:{kind:s.x.APP_ROUTE,page:"/sitemap.xml/route",pathname:"/sitemap.xml",filename:"route",bundlePath:"app/sitemap.xml/route"},resolvedPagePath:"C:\\Users\\OsmanSmith\\Desktop\\trabajitos\\tinasxshower\\app\\sitemap.xml\\route.ts",nextConfigOutput:"standalone",userland:o}),{requestAsyncStorage:p,staticGenerationAsyncStorage:u,serverHooks:c,headerHooks:m,staticGenerationBailout:d}=l,h="/sitemap.xml/route";function g(){return(0,i.patchFetch)({serverHooks:c,staticGenerationAsyncStorage:u})}},5419:(e,t,r)=>{e.exports=r(517)}};var t=require("../../webpack-runtime.js");t.C(e);var r=e=>t(t.s=e),o=t.X(0,[638],()=>r(7703));module.exports=o})();