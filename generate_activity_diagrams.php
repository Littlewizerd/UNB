<?php
/**
 * Generate Activity Diagrams in draw.io XML format
 * ระบบบันทึกเวลาเรียนของนักศึกษา
 */

$ES = "edgeStyle=orthogonalEdgeStyle;html=1;rounded=1;";

function crud($p, $title, $actor, $ap, $menu, $action, $err, $ret, $dbsave) {
    global $ES;
    return <<<XML
  <diagram name="{$title}" id="{$p}">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        <mxCell id="{$p}t" value="{$title}" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=14;fontStyle=1;" vertex="1" parent="1"><mxGeometry x="130" y="10" width="340" height="30" as="geometry"/></mxCell>
        <mxCell id="{$p}L1" value="{$actor}" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="740" as="geometry"/></mxCell>
        <mxCell id="{$p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="740" as="geometry"/></mxCell>
        <mxCell id="{$p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="740" as="geometry"/></mxCell>
        <mxCell id="{$p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;" vertex="1" parent="{$p}L1"><mxGeometry x="95" y="40" width="30" height="30" as="geometry"/></mxCell>
        <mxCell id="{$p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L1"><mxGeometry x="30" y="90" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}B" value="login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L1"><mxGeometry x="30" y="160" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;" vertex="1" parent="{$p}L2"><mxGeometry x="30" y="130" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}C" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="20" y="255" width="180" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}DB1" value="ดึงข้อมูล" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L3"><mxGeometry x="30" y="245" width="100" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}F" value="{$ap}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="10" y="340" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}G" value="{$menu}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="5" y="410" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}H" value="{$action}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="5" y="480" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}D2" value="บันทึก" style="rhombus;whiteSpace=wrap;html=1;" vertex="1" parent="{$p}L2"><mxGeometry x="30" y="455" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}I" value="{$err}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;" vertex="1" parent="{$p}L1"><mxGeometry x="5" y="575" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}DB2" value="{$dbsave}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L3"><mxGeometry x="30" y="575" width="100" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}J" value="{$ret}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;" vertex="1" parent="{$p}L1"><mxGeometry x="5" y="655" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}E" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#FFFFFF;strokeWidth=3;" vertex="1" parent="{$p}L1"><mxGeometry x="93" y="710" width="34" height="34" as="geometry"/></mxCell>
        <mxCell id="{$p}e1" style="{$ES}" edge="1" source="{$p}S" target="{$p}A" parent="1"/>
        <mxCell id="{$p}e2" style="{$ES}" edge="1" source="{$p}A" target="{$p}B" parent="1"/>
        <mxCell id="{$p}e3" style="{$ES}" edge="1" source="{$p}B" target="{$p}D1" parent="1"/>
        <mxCell id="{$p}e4" value="ไม่" style="{$ES}" edge="1" source="{$p}D1" target="{$p}C" parent="1"/>
        <mxCell id="{$p}e5" value="ใช่" style="{$ES}" edge="1" source="{$p}D1" target="{$p}DB1" parent="1"/>
        <mxCell id="{$p}e6" style="{$ES}" edge="1" source="{$p}C" target="{$p}B" parent="1"/>
        <mxCell id="{$p}e7" style="{$ES}" edge="1" source="{$p}DB1" target="{$p}F" parent="1"/>
        <mxCell id="{$p}e8" style="{$ES}" edge="1" source="{$p}F" target="{$p}G" parent="1"/>
        <mxCell id="{$p}e9" style="{$ES}" edge="1" source="{$p}G" target="{$p}H" parent="1"/>
        <mxCell id="{$p}e10" style="{$ES}" edge="1" source="{$p}H" target="{$p}D2" parent="1"/>
        <mxCell id="{$p}e11" value="ไม่" style="{$ES}" edge="1" source="{$p}D2" target="{$p}I" parent="1"/>
        <mxCell id="{$p}e12" value="ใช่" style="{$ES}" edge="1" source="{$p}D2" target="{$p}DB2" parent="1"/>
        <mxCell id="{$p}e13" style="{$ES}" edge="1" source="{$p}I" target="{$p}J" parent="1"/>
        <mxCell id="{$p}e14" style="{$ES}" edge="1" source="{$p}DB2" target="{$p}J" parent="1"/>
        <mxCell id="{$p}e15" style="{$ES}" edge="1" source="{$p}J" target="{$p}E" parent="1"/>
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
        <mxCell id="{$p}L1" value="{$actor}" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="660" as="geometry"/></mxCell>
        <mxCell id="{$p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="660" as="geometry"/></mxCell>
        <mxCell id="{$p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="660" as="geometry"/></mxCell>
        <mxCell id="{$p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;" vertex="1" parent="{$p}L1"><mxGeometry x="95" y="40" width="30" height="30" as="geometry"/></mxCell>
        <mxCell id="{$p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L1"><mxGeometry x="30" y="90" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}B" value="login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L1"><mxGeometry x="30" y="160" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;" vertex="1" parent="{$p}L2"><mxGeometry x="30" y="130" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}C" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="20" y="255" width="180" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}DB1" value="ดึงข้อมูล" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L3"><mxGeometry x="30" y="245" width="100" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}F" value="{$ap}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="10" y="330" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}G" value="{$menu}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="5" y="400" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}DB2" value="{$dbfetch}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L3"><mxGeometry x="20" y="400" width="120" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}SY" value="ประมวลผล/แสดงผล" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L2"><mxGeometry x="10" y="470" width="140" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}H" value="{$display}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="5" y="475" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}J" value="กลับไปหน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L1"><mxGeometry x="30" y="555" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}E" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#FFFFFF;strokeWidth=3;" vertex="1" parent="{$p}L1"><mxGeometry x="93" y="615" width="34" height="34" as="geometry"/></mxCell>
        <mxCell id="{$p}e1" style="{$ES}" edge="1" source="{$p}S" target="{$p}A" parent="1"/>
        <mxCell id="{$p}e2" style="{$ES}" edge="1" source="{$p}A" target="{$p}B" parent="1"/>
        <mxCell id="{$p}e3" style="{$ES}" edge="1" source="{$p}B" target="{$p}D1" parent="1"/>
        <mxCell id="{$p}e4" value="ไม่" style="{$ES}" edge="1" source="{$p}D1" target="{$p}C" parent="1"/>
        <mxCell id="{$p}e5" value="ใช่" style="{$ES}" edge="1" source="{$p}D1" target="{$p}DB1" parent="1"/>
        <mxCell id="{$p}e6" style="{$ES}" edge="1" source="{$p}C" target="{$p}B" parent="1"/>
        <mxCell id="{$p}e7" style="{$ES}" edge="1" source="{$p}DB1" target="{$p}F" parent="1"/>
        <mxCell id="{$p}e8" style="{$ES}" edge="1" source="{$p}F" target="{$p}G" parent="1"/>
        <mxCell id="{$p}e9" style="{$ES}" edge="1" source="{$p}G" target="{$p}DB2" parent="1"/>
        <mxCell id="{$p}e10" style="{$ES}" edge="1" source="{$p}DB2" target="{$p}SY" parent="1"/>
        <mxCell id="{$p}e11" style="{$ES}" edge="1" source="{$p}SY" target="{$p}H" parent="1"/>
        <mxCell id="{$p}e12" style="{$ES}" edge="1" source="{$p}H" target="{$p}J" parent="1"/>
        <mxCell id="{$p}e13" style="{$ES}" edge="1" source="{$p}J" target="{$p}E" parent="1"/>
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
        <mxCell id="{$p}L1" value="{$actor}" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="800" as="geometry"/></mxCell>
        <mxCell id="{$p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="800" as="geometry"/></mxCell>
        <mxCell id="{$p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="800" as="geometry"/></mxCell>
        <mxCell id="{$p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;" vertex="1" parent="{$p}L1"><mxGeometry x="95" y="40" width="30" height="30" as="geometry"/></mxCell>
        <mxCell id="{$p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L1"><mxGeometry x="30" y="90" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}B" value="login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L1"><mxGeometry x="30" y="155" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;" vertex="1" parent="{$p}L2"><mxGeometry x="30" y="125" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}C" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="20" y="245" width="180" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}DB1" value="ดึงข้อมูล" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L3"><mxGeometry x="30" y="235" width="100" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}F" value="{$ap}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="10" y="320" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}G" value="{$menu}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="5" y="390" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}H" value="{$select_text}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;" vertex="1" parent="{$p}L1"><mxGeometry x="5" y="460" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}DB2" value="{$dbfetch}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L3"><mxGeometry x="15" y="460" width="130" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}I" value="แสดงรายงาน" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L1"><mxGeometry x="30" y="540" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}K" value="กดส่งออก PDF" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L1"><mxGeometry x="30" y="610" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}SY" value="สร้างไฟล์ PDF" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L2"><mxGeometry x="15" y="610" width="130" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}M" value="ดาวน์โหลดสำเร็จ&#xa;กลับไปหน้ารายงาน" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="10" y="685" width="200" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}E" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#FFFFFF;strokeWidth=3;" vertex="1" parent="{$p}L1"><mxGeometry x="93" y="750" width="34" height="34" as="geometry"/></mxCell>
        <mxCell id="{$p}e1" style="{$ES}" edge="1" source="{$p}S" target="{$p}A" parent="1"/>
        <mxCell id="{$p}e2" style="{$ES}" edge="1" source="{$p}A" target="{$p}B" parent="1"/>
        <mxCell id="{$p}e3" style="{$ES}" edge="1" source="{$p}B" target="{$p}D1" parent="1"/>
        <mxCell id="{$p}e4" value="ไม่" style="{$ES}" edge="1" source="{$p}D1" target="{$p}C" parent="1"/>
        <mxCell id="{$p}e5" value="ใช่" style="{$ES}" edge="1" source="{$p}D1" target="{$p}DB1" parent="1"/>
        <mxCell id="{$p}e6" style="{$ES}" edge="1" source="{$p}C" target="{$p}B" parent="1"/>
        <mxCell id="{$p}e7" style="{$ES}" edge="1" source="{$p}DB1" target="{$p}F" parent="1"/>
        <mxCell id="{$p}e8" style="{$ES}" edge="1" source="{$p}F" target="{$p}G" parent="1"/>
        <mxCell id="{$p}e9" style="{$ES}" edge="1" source="{$p}G" target="{$p}H" parent="1"/>
        <mxCell id="{$p}e10" style="{$ES}" edge="1" source="{$p}H" target="{$p}DB2" parent="1"/>
        <mxCell id="{$p}e11" style="{$ES}" edge="1" source="{$p}DB2" target="{$p}I" parent="1"/>
        <mxCell id="{$p}e12" style="{$ES}" edge="1" source="{$p}I" target="{$p}K" parent="1"/>
        <mxCell id="{$p}e13" style="{$ES}" edge="1" source="{$p}K" target="{$p}SY" parent="1"/>
        <mxCell id="{$p}e14" style="{$ES}" edge="1" source="{$p}SY" target="{$p}M" parent="1"/>
        <mxCell id="{$p}e15" style="{$ES}" edge="1" source="{$p}M" target="{$p}E" parent="1"/>
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
        <mxCell id="{$p}L1" value="ผู้ใช้งาน" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="740" as="geometry"/></mxCell>
        <mxCell id="{$p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="740" as="geometry"/></mxCell>
        <mxCell id="{$p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="740" as="geometry"/></mxCell>
        <mxCell id="{$p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;" vertex="1" parent="{$p}L1"><mxGeometry x="95" y="40" width="30" height="30" as="geometry"/></mxCell>
        <mxCell id="{$p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L1"><mxGeometry x="30" y="90" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}B" value="กรอกชื่อผู้ใช้&#xa;และรหัสผ่าน" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="30" y="160" width="160" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;" vertex="1" parent="{$p}L2"><mxGeometry x="30" y="130" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}C" value="แจ้งเตือนข้อมูลไม่ถูกต้อง&#xa;กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;" vertex="1" parent="{$p}L1"><mxGeometry x="5" y="260" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}DB1" value="ดึงข้อมูลผู้ใช้&#xa;สร้าง Session" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L3"><mxGeometry x="15" y="245" width="130" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}F" value="หน้าแรกตามบทบาท&#xa;(Admin/Instructor/Student)" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;" vertex="1" parent="{$p}L1"><mxGeometry x="5" y="355" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}G" value="ใช้งานระบบตามบทบาท" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="10" y="435" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}H" value="กดออกจากระบบ (Logout)" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="10" y="510" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}SY" value="ลบ Session" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{$p}L2"><mxGeometry x="25" y="510" width="110" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}DB2" value="อัปเดต&#xa;Last Login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L3"><mxGeometry x="25" y="510" width="110" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}I" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{$p}L1"><mxGeometry x="20" y="600" width="180" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}E" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#FFFFFF;strokeWidth=3;" vertex="1" parent="{$p}L1"><mxGeometry x="93" y="670" width="34" height="34" as="geometry"/></mxCell>
        <mxCell id="{$p}e1" style="{$ES}" edge="1" source="{$p}S" target="{$p}A" parent="1"/>
        <mxCell id="{$p}e2" style="{$ES}" edge="1" source="{$p}A" target="{$p}B" parent="1"/>
        <mxCell id="{$p}e3" style="{$ES}" edge="1" source="{$p}B" target="{$p}D1" parent="1"/>
        <mxCell id="{$p}e4" value="ไม่" style="{$ES}" edge="1" source="{$p}D1" target="{$p}C" parent="1"/>
        <mxCell id="{$p}e5" value="ใช่" style="{$ES}" edge="1" source="{$p}D1" target="{$p}DB1" parent="1"/>
        <mxCell id="{$p}e6" style="{$ES}" edge="1" source="{$p}C" target="{$p}B" parent="1"/>
        <mxCell id="{$p}e7" style="{$ES}" edge="1" source="{$p}DB1" target="{$p}F" parent="1"/>
        <mxCell id="{$p}e8" style="{$ES}" edge="1" source="{$p}F" target="{$p}G" parent="1"/>
        <mxCell id="{$p}e9" style="{$ES}" edge="1" source="{$p}G" target="{$p}H" parent="1"/>
        <mxCell id="{$p}e10" style="{$ES}" edge="1" source="{$p}H" target="{$p}SY" parent="1"/>
        <mxCell id="{$p}e11" style="{$ES}" edge="1" source="{$p}SY" target="{$p}DB2" parent="1"/>
        <mxCell id="{$p}e12" style="{$ES}" edge="1" source="{$p}DB2" target="{$p}I" parent="1"/>
        <mxCell id="{$p}e13" style="{$ES}" edge="1" source="{$p}I" target="{$p}E" parent="1"/>
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
    "หากข้อมูลซ้ำซ้อนหรือไม่ถูกต้อง ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการตาราง", "เก็บข้อมูล&#xa;ตารางเรียน");

$pages[] = readonly_page("p07", "แดชบอร์ดสรุปข้อมูล (Admin)", "Administrator", "หน้าแรก Administrator",
    "เลือกเมนูแดชบอร์ด", "แสดงสรุปข้อมูล&#xa;เวลาเรียน/การเข้า/การขาด", "ดึงข้อมูลสรุป&#xa;การเข้าเรียน");

$pages[] = report_pdf("p08", "ส่งออกรายงาน PDF (Admin)", "Administrator", "หน้าแรก Administrator",
    "เลือกเมนูรายงาน", "เลือกประเภทรายงาน&#xa;(ผู้ใช้/รายวิชา/ห้องเรียน/&#xa;ผลเข้าเรียน/ตาราง)", "ดึงข้อมูล&#xa;รายงาน");

// ========================================
// 2. อาจารย์ (Instructor) - 7 diagrams
// ========================================
$pages[] = crud("p09", "บันทึกเวลาเรียนเข้านักศึกษา", "Instructor", "หน้าแรก Instructor",
    "เลือกเมนูบันทึกเวลาเรียน", "เลือกรายวิชา/ห้องเรียน&#xa;เลือกนักศึกษา กำหนดสถานะ&#xa;(มา/ขาด/สาย)",
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
    "เลือกเมนูข้อความ", "เลือกนักศึกษาที่ต้องการ&#xa;ส่งข้อความถึง&#xa;พิมพ์ข้อความ กดส่ง",
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
    "เลือกเมนูข้อความ", "เลือกอาจารย์ที่ต้องการ&#xa;ส่งข้อความถึง&#xa;พิมพ์ข้อความ กดส่ง",
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
    "หากรหัสผ่านไม่ถูกต้อง&#xa;หรือไม่ตรงกัน ระบบแจ้งเตือน", "เปลี่ยนรหัสผ่านสำเร็จ กลับหน้าโปรไฟล์", "อัปเดต&#xa;รหัสผ่าน");

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
echo "📄 จำนวนหน้า: " . count($pages) . " Activity Diagrams\n\n";
echo "รายการ Activity Diagrams:\n";
echo str_repeat("=", 50) . "\n\n";
echo "👨‍💼 ผู้ดูแลระบบ (Administrator)\n";
echo "  1.  จัดการบัญชีผู้ใช้\n";
echo "  2.  จัดการข้อมูลภาคเรียน\n";
echo "  3.  จัดการข้อมูลห้องเรียน\n";
echo "  4.  จัดการข้อมูลรายวิชา\n";
echo "  5.  จัดการข้อมูลนักศึกษา\n";
echo "  6.  จัดการตารางเรียน/ตารางสอน\n";
echo "  7.  แดชบอร์ดสรุปข้อมูล\n";
echo "  8.  ส่งออกรายงาน PDF\n\n";
echo "👨‍🏫 อาจารย์ (Instructor)\n";
echo "  9.  บันทึกเวลาเรียนเข้านักศึกษา\n";
echo "  10. เรียกดูรายวิชาที่สอน\n";
echo "  11. จัดการข้อมูลนักศึกษาในรายวิชา\n";
echo "  12. ค้นหาข้อมูลนักศึกษาและรายวิชา\n";
echo "  13. ส่งออกรายงาน PDF\n";
echo "  14. ดูตารางสอน\n";
echo "  15. ส่งข้อความตอบกลับถึงนักศึกษา\n\n";
echo "👨‍🎓 นักศึกษา (Student)\n";
echo "  16. แดชบอร์ดสรุปผลการเข้าห้องเรียน\n";
echo "  17. ส่งออกรายงาน PDF\n";
echo "  18. ดูตารางเรียน\n";
echo "  19. ส่งข้อความถึงอาจารย์ผู้สอน\n\n";
echo "👥 ฟังก์ชันร่วม (ทุกบทบาท)\n";
echo "  20. เข้าสู่ระบบ/ออกจากระบบ\n";
echo "  21. อัปเดตโปรไฟล์\n";
echo "  22. เปลี่ยนรหัสผ่าน\n\n";
echo "📁 เปิดไฟล์ด้วย draw.io หรือ https://app.diagrams.net\n";
