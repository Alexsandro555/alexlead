function popUpImage(url,imageWidth,imageHeight,startX,startY)
{
menuindex++;
newdiv=document.createElement('div');
newdiv.style.zIndex=menuindex+12200100;
newdiv.style.position='absolute';
newdiv.style.top=0;
newdiv.style.left=0;
newdiv.style.width="100%";
newdiv.style.height=arsenal.page.pageHeight-2;
newdiv.style.margin='0px';
newdiv.style.backgroundColor='#555';
newdiv.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=60)";
newdiv.style.KhtmlOpacity=0.6;
newdiv.style.MozOpacity=0.6;
newdiv.style.opacity=0.6;
newdiv.onclick=function () {this.style.display='none';this.photo.style.display='none';}
imgdiv=document.createElement('div');
newdiv.photo=imgdiv;
imgdiv.style.position='absolute';
imgdiv.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=100)";
imgdiv.style.KhtmlOpacity=1;
imgdiv.style.MozOpacity=1;
imgdiv.back=newdiv;
imgdiv.onclick=function () {this.style.display='none';imgdiv.back.style.display='none';}
imgdiv.style.opacity=1;
imgdiv.style.zIndex=menuindex+12200101;
imgdiv.style.left=arsenal.page.scrollLeft+Math.round((arsenal.page.width-imageWidth)/2)-10+"px";
imgdiv.style.top=arsenal.page.scrollTop+Math.round((arsenal.page.height-imageHeight)/2)-10+"px";
imgdiv.innerHTML="<table cellpadding='0' cellspacing='0' ><tbody valign='top'><tr height='10'><td style='background:url(/images/image_border.gif) no-repeat top left;width:10px'></td><td style='background:url(/images/image_border_up.gif) repeat-x top left'></td><td style='background:url(/images/image_border.gif) no-repeat top right;width:10px'></td></tr><tr ><td style='background:url(/images/image_border_left.gif) repeat-y top left'></td><td><img src='"+url+"' style='-moz-opacity:1' /></td><td style='background:url(/images/image_border_right.gif) repeat-y top right'></td></tr><tr height='10'><td style='background:url(/images/image_border.gif) no-repeat bottom left;width:10px'></td><td style='background:url(/images/image_border_down.gif) repeat-x top left'></td><td style='background:url(/images/image_border.gif) no-repeat bottom right;width:10px'></td></tr></tbody></table>";
document.body.appendChild(newdiv);
document.body.appendChild(imgdiv);
}
var menuindex=0;