/* <style> */
[data-elgg-icon]:before {
    background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/elgg_sprites.png) no-repeat left;
    content: "";
	display: inline-block;
    width: 16px;
	height: 16px;
	margin-right: 5px; /* Assumes the element has padding of its own already */
    vertical-align: text-bottom;
}
[data-elgg-icon=arrow-left]:before {
	background-position: 0 -0px;
}
[data-elgg-icon=arrow-right]:before {
	background-position: 0 -18px;
}
[data-elgg-icon=arrow-two-head]:before {
	background-position: 0 -36px;
}
[data-elgg-icon=attention]:hover:before {
	background-position: 0 -54px;
}
[data-elgg-icon=attention]:before {
	background-position: 0 -72px;
}
[data-elgg-icon=calendar]:before {
	background-position: 0 -90px;
}
[data-elgg-icon=cell-phone]:before {
	background-position: 0 -108px;
}
[data-elgg-icon=checkmark]:hover:before {
	background-position: 0 -126px;
}
[data-elgg-icon=checkmark]:before {
	background-position: 0 -144px;
}
[data-elgg-icon=clip]:hover:before {
	background-position: 0 -162px;
}
[data-elgg-icon=clip]:before {
	background-position: 0 -180px;
}
[data-elgg-icon=cursor-drag-arrow]:before {
	background-position: 0 -198px;
}
[data-elgg-icon=delete-alt]:hover:before {
	background-position: 0 -216px;
}
[data-elgg-icon=delete-alt]:before {
	background-position: 0 -234px;
}
[data-elgg-icon=delete]:hover:before {
	background-position: 0 -252px;
}
[data-elgg-icon=delete]:before {
	background-position: 0 -270px;
}
[data-elgg-icon=download]:hover:before {
	background-position: 0 -288px;
}
[data-elgg-icon=download]:before {
	background-position: 0 -306px;
}
[data-elgg-icon=eye]:before {
	background-position: 0 -324px;
}
[data-elgg-icon=facebook]:before {
	background-position: 0 -342px;
}
[data-elgg-icon=grid]:hover:before {
	background-position: 0 -360px;
}
[data-elgg-icon=grid]:before {
	background-position: 0 -378px;
}
[data-elgg-icon=home]:hover:before {
	background-position: 0 -396px;
}
[data-elgg-icon=home]:before {
	background-position: 0 -414px;
}
[data-elgg-icon=hover-menu]:hover:before {
	background-position: 0 -432px;
}
[data-elgg-icon=hover-menu]:before {
	background-position: 0 -450px;
}
[data-elgg-icon=info]:hover:before {
	background-position: 0 -468px;
}
[data-elgg-icon=info]:before {
	background-position: 0 -486px;
}
[data-elgg-icon=link]:hover:before {
	background-position: 0 -504px;
}
[data-elgg-icon=link]:before {
	background-position: 0 -522px;
}
[data-elgg-icon=list]:before {
	background-position: 0 -540px;
}
[data-elgg-icon=lock-closed]:before {
	background-position: 0 -558px;
}
[data-elgg-icon=lock-open]:before {
	background-position: 0 -576px;
}
[data-elgg-icon=mail-alt]:hover:before {
	background-position: 0 -594px;
}
[data-elgg-icon=mail-alt]:before {
	background-position: 0 -612px;
}
[data-elgg-icon=mail]:hover:before {
	background-position: 0 -630px;
}
[data-elgg-icon=mail]:before {
	background-position: 0 -648px;
}
[data-elgg-icon=photo]:before {
	background-position: 0 -666px;
}
[data-elgg-icon=print-alt]:before {
	background-position: 0 -684px;
}
[data-elgg-icon=print]:before {
	background-position: 0 -702px;
}
[data-elgg-icon=push-pin-alt]:before {
	background-position: 0 -720px;
}
[data-elgg-icon=push-pin]:before {
	background-position: 0 -738px;
}
[data-elgg-icon=redo]:before {
	background-position: 0 -756px;
}
[data-elgg-icon=refresh]:hover:before {
	background-position: 0 -774px;
}
[data-elgg-icon=refresh]:before {
	background-position: 0 -792px;
}
[data-elgg-icon=round-arrow-left]:before {
	background-position: 0 -810px;
}
[data-elgg-icon=round-arrow-right]:before {
	background-position: 0 -828px;
}
[data-elgg-icon=round-checkmark]:before {
	background-position: 0 -846px;
}
[data-elgg-icon=round-minus]:before {
	background-position: 0 -864px;
}
[data-elgg-icon=round-plus]:before {
	background-position: 0 -882px;
}
[data-elgg-icon=rss]:before {
	background-position: 0 -900px;
}
[data-elgg-icon=search-focus]:before {
	background-position: 0 -918px;
}
[data-elgg-icon=search]:before {
	background-position: 0 -936px;
}
[data-elgg-icon=settings-alt]:hover:before {
	background-position: 0 -954px;
}
[data-elgg-icon=settings-alt]:before {
	background-position: 0 -972px;
}
[data-elgg-icon=settings]:before {
	background-position: 0 -990px;
}
[data-elgg-icon=share]:hover:before {
	background-position: 0 -1008px;
}
[data-elgg-icon=share]:before {
	background-position: 0 -1026px;
}
[data-elgg-icon=shop-cart]:hover:before {
	background-position: 0 -1044px;
}
[data-elgg-icon=shop-cart]:before {
	background-position: 0 -1062px;
}
[data-elgg-icon=speech-bubble-alt]:hover:before {
	background-position: 0 -1080px;
}
[data-elgg-icon=speech-bubble-alt]:before {
	background-position: 0 -1098px;
}
[data-elgg-icon=speech-bubble]:hover:before {
	background-position: 0 -1116px;
}
[data-elgg-icon=speech-bubble]:before {
	background-position: 0 -1134px;
}
[data-elgg-icon=star-alt]:before {
	background-position: 0 -1152px;
}
[data-elgg-icon=star-empty]:hover:before {
	background-position: 0 -1170px;
}
[data-elgg-icon=star-empty]:before {
	background-position: 0 -1188px;
}
[data-elgg-icon=star]:hover:before {
	background-position: 0 -1206px;
}
[data-elgg-icon=star]:before {
	background-position: 0 -1224px;
}
[data-elgg-icon=tag]:hover:before {
	background-position: 0 -1242px;
}
[data-elgg-icon=tag]:before {
	background-position: 0 -1260px;
}
[data-elgg-icon=thumbs-down-alt]:hover:before {
	background-position: 0 -1278px;
}
[data-elgg-icon=thumbs-down]:hover:before,
[data-elgg-icon=thumbs-down-alt]:before {
	background-position: 0 -1296px;
}
[data-elgg-icon=thumbs-down]:before {
	background-position: 0 -1314px;
}
[data-elgg-icon=thumbs-up-alt]:hover:before {
	background-position: 0 -1332px;
}
[data-elgg-icon=thumbs-up]:hover:before,
[data-elgg-icon=thumbs-up-alt]:before {
	background-position: 0 -1350px;
}
[data-elgg-icon=thumbs-up]:before {
	background-position: 0 -1368px;
}
[data-elgg-icon=trash]:before {
	background-position: 0 -1386px;
}
[data-elgg-icon=twitter]:before {
	background-position: 0 -1404px;
}
[data-elgg-icon=undo]:before {
	background-position: 0 -1422px;
}
[data-elgg-icon=user]:hover:before {
	background-position: 0 -1440px;
}
[data-elgg-icon=user]:before {
	background-position: 0 -1458px;
}
[data-elgg-icon=users]:hover:before {
	background-position: 0 -1476px;
}
[data-elgg-icon=users]:before {
	background-position: 0 -1494px;
}
[data-elgg-icon=video]:before {
	background-position: 0 -1512px;
}