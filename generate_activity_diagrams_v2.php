<?php
/**
 * Generate Activity Diagrams in draw.io XML format (with proper edge geometry)
 * ระบบบันทึกเวลาเรียนของนักศึกษา
 */

$ES = "edgeStyle=orthogonalEdgeStyle;html=1;rounded=0;entryX=0.5;entryY=0;entryDx=0;entryDy=0;exitX=0.5;exitY=1;exitDx=0;exitDy=0;";

function crud($p, $title, $actor, $ap, $menu, $action, $err, $ret, $dbsave) {
    global $ES;
    // All coordinates are absolute (parent="1")
    // Swimlane positions: L1=30, L2=250, L3=410  (widths: 220, 160, 160)
    // Swimlane Y start = 65 (40 + 25 header)
    
    $L1x = 30; $L2x = 250; $L3x = 410;
    $Ytop = 40;
    
    return <<<XML
  <diagram name="{$title}" id="{$p}">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        <mxCell id="{$p}t" value="{$title}" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=14;fontStyle=1;" vertex="1" parent="1"><mxGeometry x="130" y="10" width="340" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}L1" value="{$actor}" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="740" as="geometry"/></mxCell>
        <mxCell id="{$p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="740" as="geometry"/></mxCell>
        <mxCell id="{$p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=#d5e8d4;strokeColor=#82b366;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="740" as="geometry"/></mxCell>
        
        <mxCell id="{$p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;" vertex="1" parent="1"><mxGeometry x="125" y="80" width="30" height="30" as="geometry"/></mxCell>
        <mxCell id="{$p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="60" y="130" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}B" value="login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="60" y="200" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="1"><mxGeometry x="280" y="170" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}C" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#f8cecc;strokeColor=#b85450;" vertex="1" parent="1"><mxGeometry x="50" y="295" width="180" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}DB1" value="ดึงข้อมูล" style="shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=10;fillColor=#d5e8d4;strokeColor=#82b366;" vertex="1" parent="1"><mxGeometry x="440" y="275" width="100" height="50" as="geometry"/></mxCell>
        <mxCell id="{$p}F" value="{$ap}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="1"><mxGeometry x="40" y="370" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}G" value="{$menu}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="35" y="440" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}H" value="{$action}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="35" y="510" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}D2" value="บันทึก" style="rhombus;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="1"><mxGeometry x="280" y="490" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}I" value="{$err}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;fillColor=#f8cecc;strokeColor=#b85450;" vertex="1" parent="1"><mxGeometry x="35" y="605" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}DB2" value="{$dbsave}" style="shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=10;fillColor=#d5e8d4;strokeColor=#82b366;" vertex="1" parent="1"><mxGeometry x="440" y="600" width="100" height="50" as="geometry"/></mxCell>
        <mxCell id="{$p}J" value="{$ret}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="1"><mxGeometry x="35" y="685" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}E" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#FFFFFF;strokeWidth=3;" vertex="1" parent="1"><mxGeometry x="123" y="745" width="34" height="34" as="geometry"/></mxCell>
        
        <mxCell id="{$p}e1" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}S" target="{$p}A"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e2" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}A" target="{$p}B"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e3" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;" edge="1" parent="1" source="{$p}B" target="{$p}D1"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e4" value="ไม่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}D1" target="{$p}C"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e5" value="ใช่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}D1" target="{$p}DB1"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e6" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;dashed=1;" edge="1" parent="1" source="{$p}C" target="{$p}B"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="30" y="315"/><mxPoint x="30" y="220"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e7" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}DB1" target="{$p}F"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="440" y="350"/><mxPoint x="140" y="350"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e8" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}F" target="{$p}G"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e9" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}G" target="{$p}H"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e10" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;" edge="1" parent="1" source="{$p}H" target="{$p}D2"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e11" value="ไม่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}D2" target="{$p}I"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e12" value="ใช่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}D2" target="{$p}DB2"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e13" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}I" target="{$p}J"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e14" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=1;entryY=0.5;endArrow=classic;" edge="1" parent="1" source="{$p}DB2" target="{$p}J"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="440" y="705"/><mxPoint x="245" y="705"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e15" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}J" target="{$p}E"><mxGeometry relative="1" as="geometry"/></mxCell>
      </root>
    </mxGraphModel>
  </diagram>

XML;
}


function readonly_page($p, $title, $actor, $ap, $menu, $display, $dbfetch) {
    global $ES;
    return <<<XML
  <diagram name="{$title}" id="{$p}">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        <mxCell id="{$p}t" value="{$title}" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=14;fontStyle=1;" vertex="1" parent="1"><mxGeometry x="130" y="10" width="340" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}L1" value="{$actor}" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="660" as="geometry"/></mxCell>
        <mxCell id="{$p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="660" as="geometry"/></mxCell>
        <mxCell id="{$p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=#d5e8d4;strokeColor=#82b366;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="660" as="geometry"/></mxCell>
        
        <mxCell id="{$p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;" vertex="1" parent="1"><mxGeometry x="125" y="80" width="30" height="30" as="geometry"/></mxCell>
        <mxCell id="{$p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="60" y="130" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}B" value="login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="60" y="200" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="1"><mxGeometry x="280" y="170" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}C" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#f8cecc;strokeColor=#b85450;" vertex="1" parent="1"><mxGeometry x="50" y="295" width="180" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}DB1" value="ดึงข้อมูล" style="shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=10;fillColor=#d5e8d4;strokeColor=#82b366;" vertex="1" parent="1"><mxGeometry x="440" y="275" width="100" height="50" as="geometry"/></mxCell>
        <mxCell id="{$p}F" value="{$ap}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="1"><mxGeometry x="40" y="370" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}G" value="{$menu}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="35" y="440" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}DB2" value="{$dbfetch}" style="shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=10;fillColor=#d5e8d4;strokeColor=#82b366;" vertex="1" parent="1"><mxGeometry x="430" y="440" width="120" height="50" as="geometry"/></mxCell>
        <mxCell id="{$p}SY" value="ประมวลผล/แสดงผล" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="1"><mxGeometry x="260" y="510" width="140" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}H" value="{$display}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="35" y="515" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}J" value="กลับไปหน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="1"><mxGeometry x="60" y="595" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}E" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#FFFFFF;strokeWidth=3;" vertex="1" parent="1"><mxGeometry x="123" y="660" width="34" height="34" as="geometry"/></mxCell>
        
        <mxCell id="{$p}e1" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}S" target="{$p}A"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e2" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}A" target="{$p}B"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e3" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;" edge="1" parent="1" source="{$p}B" target="{$p}D1"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e4" value="ไม่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}D1" target="{$p}C"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e5" value="ใช่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}D1" target="{$p}DB1"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e6" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;dashed=1;" edge="1" parent="1" source="{$p}C" target="{$p}B"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="30" y="315"/><mxPoint x="30" y="220"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e7" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}DB1" target="{$p}F"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="440" y="350"/><mxPoint x="140" y="350"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e8" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}F" target="{$p}G"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e9" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;" edge="1" parent="1" source="{$p}G" target="{$p}DB2"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e10" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=1;entryY=0.5;endArrow=classic;" edge="1" parent="1" source="{$p}DB2" target="{$p}SY"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e11" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=1;entryY=0.5;endArrow=classic;" edge="1" parent="1" source="{$p}SY" target="{$p}H"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e12" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}H" target="{$p}J"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e13" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}J" target="{$p}E"><mxGeometry relative="1" as="geometry"/></mxCell>
      </root>
    </mxGraphModel>
  </diagram>

XML;
}

function report_pdf($p, $title, $actor, $ap, $menu, $select_text, $dbfetch) {
    global $ES;
    return <<<XML
  <diagram name="{$title}" id="{$p}">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        <mxCell id="{$p}t" value="{$title}" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=14;fontStyle=1;" vertex="1" parent="1"><mxGeometry x="130" y="10" width="340" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}L1" value="{$actor}" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="800" as="geometry"/></mxCell>
        <mxCell id="{$p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="800" as="geometry"/></mxCell>
        <mxCell id="{$p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=#d5e8d4;strokeColor=#82b366;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="800" as="geometry"/></mxCell>
        
        <mxCell id="{$p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;" vertex="1" parent="1"><mxGeometry x="125" y="80" width="30" height="30" as="geometry"/></mxCell>
        <mxCell id="{$p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="60" y="130" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}B" value="login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="60" y="195" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="1"><mxGeometry x="280" y="165" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}C" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#f8cecc;strokeColor=#b85450;" vertex="1" parent="1"><mxGeometry x="50" y="285" width="180" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}DB1" value="ดึงข้อมูล" style="shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=10;fillColor=#d5e8d4;strokeColor=#82b366;" vertex="1" parent="1"><mxGeometry x="440" y="270" width="100" height="50" as="geometry"/></mxCell>
        <mxCell id="{$p}F" value="{$ap}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="1"><mxGeometry x="40" y="360" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}G" value="{$menu}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="35" y="430" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}H" value="{$select_text}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="35" y="500" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}DB2" value="{$dbfetch}" style="shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=10;fillColor=#d5e8d4;strokeColor=#82b366;" vertex="1" parent="1"><mxGeometry x="425" y="495" width="130" height="50" as="geometry"/></mxCell>
        <mxCell id="{$p}I" value="แสดงรายงาน" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="60" y="580" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}K" value="กดส่งออก PDF" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=#e1d5e7;strokeColor=#9673a6;" vertex="1" parent="1"><mxGeometry x="60" y="650" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}SY" value="สร้างไฟล์ PDF" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="1"><mxGeometry x="265" y="650" width="130" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}M" value="ดาวน์โหลดสำเร็จ&#xa;กลับไปหน้ารายงาน" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="1"><mxGeometry x="40" y="725" width="200" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}E" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#FFFFFF;strokeWidth=3;" vertex="1" parent="1"><mxGeometry x="123" y="795" width="34" height="34" as="geometry"/></mxCell>
        
        <mxCell id="{$p}e1" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}S" target="{$p}A"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e2" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}A" target="{$p}B"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e3" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;" edge="1" parent="1" source="{$p}B" target="{$p}D1"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e4" value="ไม่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}D1" target="{$p}C"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e5" value="ใช่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}D1" target="{$p}DB1"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e6" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;dashed=1;" edge="1" parent="1" source="{$p}C" target="{$p}B"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="30" y="305"/><mxPoint x="30" y="215"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e7" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}DB1" target="{$p}F"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="440" y="345"/><mxPoint x="140" y="345"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e8" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}F" target="{$p}G"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e9" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}G" target="{$p}H"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e10" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;" edge="1" parent="1" source="{$p}H" target="{$p}DB2"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e11" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}DB2" target="{$p}I"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="425" y="565"/><mxPoint x="140" y="565"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e12" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}I" target="{$p}K"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e13" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;" edge="1" parent="1" source="{$p}K" target="{$p}SY"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e14" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}SY" target="{$p}M"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="265" y="710"/><mxPoint x="140" y="710"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e15" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}M" target="{$p}E"><mxGeometry relative="1" as="geometry"/></mxCell>
      </root>
    </mxGraphModel>
  </diagram>

XML;
}


function login_logout_page($p, $title) {
    global $ES;
    return <<<XML
  <diagram name="{$title}" id="{$p}">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        <mxCell id="{$p}t" value="{$title}" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=14;fontStyle=1;" vertex="1" parent="1"><mxGeometry x="130" y="10" width="340" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}L1" value="ผู้ใช้งาน" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="740" as="geometry"/></mxCell>
        <mxCell id="{$p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="740" as="geometry"/></mxCell>
        <mxCell id="{$p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=#d5e8d4;strokeColor=#82b366;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="740" as="geometry"/></mxCell>
        
        <mxCell id="{$p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;" vertex="1" parent="1"><mxGeometry x="125" y="80" width="30" height="30" as="geometry"/></mxCell>
        <mxCell id="{$p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="60" y="130" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}B" value="กรอกชื่อผู้ใช้&#xa;และรหัสผ่าน" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="60" y="200" width="160" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="1"><mxGeometry x="280" y="170" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}C" value="แจ้งเตือนข้อมูลไม่ถูกต้อง&#xa;กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;fillColor=#f8cecc;strokeColor=#b85450;" vertex="1" parent="1"><mxGeometry x="35" y="300" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}DB1" value="ดึงข้อมูลผู้ใช้&#xa;สร้าง Session" style="shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=10;fontSize=10;fillColor=#d5e8d4;strokeColor=#82b366;" vertex="1" parent="1"><mxGeometry x="425" y="280" width="130" height="55" as="geometry"/></mxCell>
        <mxCell id="{$p}F" value="หน้าแรกตามบทบาท&#xa;(Admin/Instructor/Student)" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="1"><mxGeometry x="35" y="395" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}G" value="ใช้งานระบบตามบทบาท" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#f5f5f5;strokeColor=#666666;fontColor=#333333;" vertex="1" parent="1"><mxGeometry x="40" y="475" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}H" value="กดออกจากระบบ (Logout)" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#e1d5e7;strokeColor=#9673a6;" vertex="1" parent="1"><mxGeometry x="40" y="550" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}SY" value="ลบ Session" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="1"><mxGeometry x="275" y="550" width="110" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}DB2" value="อัปเดต&#xa;Last Login" style="shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=10;fontSize=10;fillColor=#d5e8d4;strokeColor=#82b366;" vertex="1" parent="1"><mxGeometry x="435" y="540" width="110" height="55" as="geometry"/></mxCell>
        <mxCell id="{$p}I" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="1"><mxGeometry x="50" y="640" width="180" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}E" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#FFFFFF;strokeWidth=3;" vertex="1" parent="1"><mxGeometry x="123" y="710" width="34" height="34" as="geometry"/></mxCell>
        
        <mxCell id="{$p}e1" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}S" target="{$p}A"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e2" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}A" target="{$p}B"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e3" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;" edge="1" parent="1" source="{$p}B" target="{$p}D1"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e4" value="ไม่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}D1" target="{$p}C"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e5" value="ใช่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}D1" target="{$p}DB1"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e6" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;dashed=1;" edge="1" parent="1" source="{$p}C" target="{$p}B"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="30" y="322"/><mxPoint x="30" y="222"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e7" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}DB1" target="{$p}F"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="425" y="370"/><mxPoint x="140" y="370"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e8" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}F" target="{$p}G"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e9" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}G" target="{$p}H"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e10" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;" edge="1" parent="1" source="{$p}H" target="{$p}SY"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e11" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;" edge="1" parent="1" source="{$p}SY" target="{$p}DB2"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e12" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}DB2" target="{$p}I"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="435" y="620"/><mxPoint x="140" y="620"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e13" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;" edge="1" parent="1" source="{$p}I" target="{$p}E"><mxGeometry relative="1" as="geometry"/></mxCell>
      </root>
    </mxGraphModel>
  </diagram>

XML;
}

// =============================================
// สร้างทุกหน้า
// =============================================
$pages = [];

// ========================================
// 1. ผู้ดูแลระบบ (Administrator) - 8 diagrams
// ========================================
$pages[] = crud("p01", "จัดการบัญชีผู้ใช้", "Administrator", "หน้าแรก Administrator",
    "เลือกเมนูจัดการบัญชีผู้ใช้", "เลือกผู้ใช้/กำหนดสิทธิ์",
    "หากไม่สามารถกำหนดสิทธิ์ได้ ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการบัญชีผู้ใช้", "เก็บข้อมูล");

$pages[] = crud("p02", "จัดการข้อมูลภาคเรียน", "Administrator", "หน้าแรก Administrator",
    "เลือกเมนูจัดการภาคเรียน", "เพิ่ม/แก้ไข/ลบ ข้อมูลภาคเรียน",
    "หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการภาคเรียน", "เก็บข้อมูล&#xa;ภาคเรียน");

$pages[] = crud("p03", "จัดการข้อมูลห้องเรียน", "Administrator", "หน้าแรก Administrator",
    "เลือกเมนูจัดการห้องเรียน", "เพิ่ม/แก้ไข/ลบ ข้อมูลห้องเรียน",
    "หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการห้องเรียน", "เก็บข้อมูล&#xa;ห้องเรียน");

$pages[] = crud("p04", "จัดการข้อมูลรายวิชา", "Administrator", "หน้าแรก Administrator",
    "เลือกเมนูจัดการรายวิชา", "เพิ่ม/แก้ไข/ลบ ข้อมูลรายวิชา",
    "หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการรายวิชา", "เก็บข้อมูล&#xa;รายวิชา");

$pages[] = crud("p05", "จัดการข้อมูลนักศึกษา", "Administrator", "หน้าแรก Administrator",
    "เลือกเมนูจัดการนักศึกษา", "เพิ่ม/แก้ไข/ลบ ข้อมูลนักศึกษา",
    "หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการนักศึกษา", "เก็บข้อมูล&#xa;นักศึกษา");

$pages[] = crud("p06", "จัดการตารางเรียน/ตารางสอน", "Administrator", "หน้าแรก Administrator",
    "เลือกเมนูจัดการตารางเรียน/สอน", "เพิ่ม/แก้ไข/ลบ ตารางเรียน&#xa;เลือก วิชา/ห้อง/เวลา/อาจารย์",
    "หากข้อมูลซ้ำซ้อน ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการตาราง", "เก็บข้อมูล&#xa;ตารางเรียน");

$pages[] = readonly_page("p07", "แดชบอร์ดสรุปข้อมูล (Admin)", "Administrator", "หน้าแรก Administrator",
    "เลือกเมนูแดชบอร์ด", "แสดงสรุปข้อมูล&#xa;เวลาเรียน/การเข้า/การขาด", "ดึงข้อมูลสรุป&#xa;การเข้าเรียน");

$pages[] = report_pdf("p08", "ส่งออกรายงาน PDF (Admin)", "Administrator", "หน้าแรก Administrator",
    "เลือกเมนูรายงาน", "เลือกประเภทรายงาน&#xa;(ผู้ใช้/รายวิชา/ห้องเรียน/&#xa;ผลเข้าเรียน/ตาราง)", "ดึงข้อมูล&#xa;รายงาน");

// ========================================
// 2. อาจารย์ (Instructor) - 7 diagrams
// ========================================
$pages[] = crud("p09", "บันทึกเวลาเรียนเข้านักศึกษา", "Instructor", "หน้าแรก Instructor",
    "เลือกเมนูบันทึกเวลาเรียน", "เลือกรายวิชา/ห้องเรียน&#xa;กำหนดสถานะ (มา/ขาด/สาย)",
    "หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน", "กลับไปหน้าบันทึกเวลาเรียน", "เก็บข้อมูล&#xa;การเข้าเรียน");

$pages[] = readonly_page("p10", "เรียกดูรายวิชาที่สอน", "Instructor", "หน้าแรก Instructor",
    "เลือกเมนูรายวิชาที่สอน", "แสดงรายวิชาที่สอน&#xa;ในภาคเรียนปัจจุบัน", "ดึงข้อมูล&#xa;รายวิชา");

$pages[] = crud("p11", "จัดการข้อมูลนักศึกษาในรายวิชา", "Instructor", "หน้าแรก Instructor",
    "เลือกเมนูจัดการนักศึกษา&#xa;ในรายวิชา", "เพิ่ม/แก้ไข/ลบ/ค้นหา&#xa;นักศึกษาในรายวิชา",
    "หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการนักศึกษา", "เก็บข้อมูล&#xa;นักศึกษา");

$pages[] = readonly_page("p12", "ค้นหาข้อมูลนักศึกษาและรายวิชา", "Instructor", "หน้าแรก Instructor",
    "เลือกเมนูค้นหาข้อมูล", "แสดงผลการค้นหา&#xa;นักศึกษา/รายวิชา", "ค้นหาข้อมูล&#xa;ในฐานข้อมูล");

$pages[] = report_pdf("p13", "ส่งออกรายงาน PDF (Instructor)", "Instructor", "หน้าแรก Instructor",
    "เลือกเมนูรายงาน", "เลือกรายวิชา/ห้องเรียน&#xa;สรุปผลการเข้าเรียน", "ดึงข้อมูล&#xa;ผลการเข้าเรียน");

$pages[] = readonly_page("p14", "ดูตารางสอน", "Instructor", "หน้าแรก Instructor",
    "เลือกเมนูตารางสอน", "แสดงตารางสอน&#xa;ของอาจารย์", "ดึงข้อมูล&#xa;ตารางสอน");

$pages[] = crud("p15", "ส่งข้อความตอบกลับถึงนักศึกษา", "Instructor", "หน้าแรก Instructor",
    "เลือกเมนูข้อความ", "เลือกนักศึกษาที่ต้องการ&#xa;ส่งข้อความถึง พิมพ์ข้อความ",
    "หากข้อมูลไม่ครบ ระบบจะแจ้งเตือน", "กลับไปหน้าข้อความ", "เก็บข้อความ");

// ========================================
// 3. นักศึกษา (Student) - 4 diagrams
// ========================================
$pages[] = readonly_page("p16", "แดชบอร์ดสรุปผลการเข้าห้องเรียน", "Student", "หน้าแรก Student",
    "เลือกเมนูแดชบอร์ด", "แสดงสรุปผลการเข้าเรียน&#xa;มา/ขาด/สาย", "ดึงข้อมูล&#xa;การเข้าเรียน");

$pages[] = report_pdf("p17", "ส่งออกรายงาน PDF (Student)", "Student", "หน้าแรก Student",
    "เลือกเมนูรายงาน", "เลือกรายวิชา&#xa;ดูสรุปผลการเข้าเรียน", "ดึงข้อมูล&#xa;ผลการเข้าเรียน");

$pages[] = readonly_page("p18", "ดูตารางเรียน", "Student", "หน้าแรก Student",
    "เลือกเมนูตารางเรียน", "แสดงตารางเรียน&#xa;ของนักศึกษา", "ดึงข้อมูล&#xa;ตารางเรียน");

$pages[] = crud("p19", "ส่งข้อความถึงอาจารย์ผู้สอน", "Student", "หน้าแรก Student",
    "เลือกเมนูข้อความ", "เลือกอาจารย์ที่ต้องการ&#xa;ส่งข้อความถึง พิมพ์ข้อความ",
    "หากข้อมูลไม่ครบ ระบบจะแจ้งเตือน", "กลับไปหน้าข้อความ", "เก็บข้อความ");

// ========================================
// 4. ฟังก์ชันร่วม (Shared) - 3 diagrams
// ========================================
$pages[] = login_logout_page("p20", "เข้าสู่ระบบ/ออกจากระบบ");

$pages[] = crud("p21", "อัปเดตโปรไฟล์", "ผู้ใช้งาน (ทุกบทบาท)", "หน้าแรกตามบทบาท",
    "เลือกเมนูโปรไฟล์", "แก้ไขข้อมูลส่วนตัว&#xa;(ชื่อ/อีเมล/เบอร์โทร)",
    "หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน", "อัปเดตสำเร็จ กลับหน้าโปรไฟล์", "อัปเดต&#xa;ข้อมูลโปรไฟล์");

$pages[] = crud("p22", "เปลี่ยนรหัสผ่าน", "ผู้ใช้งาน (ทุกบทบาท)", "หน้าแรกตามบทบาท",
    "เลือกเมนูเปลี่ยนรหัสผ่าน", "กรอกรหัสผ่านเดิม&#xa;กรอกรหัสผ่านใหม่ และยืนยัน",
    "หากรหัสผ่านไม่ถูกต้อง ระบบแจ้งเตือน", "เปลี่ยนรหัสผ่านสำเร็จ กลับหน้าโปรไฟล์", "อัปเดต&#xa;รหัสผ่าน");

// =============================================
// สร้างไฟล์ draw.io
// =============================================
@mkdir('diagrams', 0777, true);

$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml .= '<mxfile host="app.diagrams.net" modified="2026-02-15T00:00:00.000Z" agent="draw.io" type="device">' . "\n";
foreach ($pages as $page) {
    $xml .= $page;
}
$xml .= '</mxfile>' . "\n";

$filepath = 'diagrams/activity_diagrams.drawio';
file_put_contents($filepath, $xml);

echo "✅ สร้างไฟล์สำเร็จ: {$filepath}\n";
echo "📄 จำนวนหน้า: " . count($pages) . " Activity Diagrams\n";
echo "🔗 เส้นโยงครบถ้วน พร้อมเปิดใน draw.io\n";
