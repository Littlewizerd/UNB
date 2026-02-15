#!/usr/bin/env python3
"""
Generate Activity Diagrams in draw.io XML format
ระบบบันทึกเวลาเรียนของนักศึกษา
"""
import os

ES = "edgeStyle=orthogonalEdgeStyle;html=1;rounded=1;"

def crud(p, title, actor, ap, menu, action, err, ret, dbsave):
    """CRUD pattern: login → select menu → action → save/error → return"""
    return f'''  <diagram name="{title}" id="{p}">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        <mxCell id="{p}t" value="{title}" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=14;fontStyle=1;" vertex="1" parent="1"><mxGeometry x="130" y="10" width="340" height="30" as="geometry"/></mxCell>
        <mxCell id="{p}L1" value="{actor}" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="740" as="geometry"/></mxCell>
        <mxCell id="{p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="740" as="geometry"/></mxCell>
        <mxCell id="{p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="740" as="geometry"/></mxCell>
        <mxCell id="{p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;" vertex="1" parent="{p}L1"><mxGeometry x="95" y="40" width="30" height="30" as="geometry"/></mxCell>
        <mxCell id="{p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L1"><mxGeometry x="30" y="90" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}B" value="login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L1"><mxGeometry x="30" y="160" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;" vertex="1" parent="{p}L2"><mxGeometry x="30" y="130" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{p}C" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="20" y="255" width="180" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}DB1" value="ดึงข้อมูล" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L3"><mxGeometry x="30" y="245" width="100" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}F" value="{ap}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="10" y="340" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}G" value="{menu}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="5" y="410" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}H" value="{action}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="5" y="480" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{p}D2" value="บันทึก" style="rhombus;whiteSpace=wrap;html=1;" vertex="1" parent="{p}L2"><mxGeometry x="30" y="455" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{p}I" value="{err}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;" vertex="1" parent="{p}L1"><mxGeometry x="5" y="575" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{p}DB2" value="{dbsave}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L3"><mxGeometry x="30" y="575" width="100" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}J" value="{ret}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;" vertex="1" parent="{p}L1"><mxGeometry x="5" y="655" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}E" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#FFFFFF;strokeWidth=3;" vertex="1" parent="{p}L1"><mxGeometry x="93" y="710" width="34" height="34" as="geometry"/></mxCell>
        <mxCell id="{p}e1" style="{ES}" edge="1" source="{p}S" target="{p}A" parent="1"/>
        <mxCell id="{p}e2" style="{ES}" edge="1" source="{p}A" target="{p}B" parent="1"/>
        <mxCell id="{p}e3" style="{ES}" edge="1" source="{p}B" target="{p}D1" parent="1"/>
        <mxCell id="{p}e4" value="ไม่" style="{ES}" edge="1" source="{p}D1" target="{p}C" parent="1"/>
        <mxCell id="{p}e5" value="ใช่" style="{ES}" edge="1" source="{p}D1" target="{p}DB1" parent="1"/>
        <mxCell id="{p}e6" style="{ES}" edge="1" source="{p}C" target="{p}B" parent="1"/>
        <mxCell id="{p}e7" style="{ES}" edge="1" source="{p}DB1" target="{p}F" parent="1"/>
        <mxCell id="{p}e8" style="{ES}" edge="1" source="{p}F" target="{p}G" parent="1"/>
        <mxCell id="{p}e9" style="{ES}" edge="1" source="{p}G" target="{p}H" parent="1"/>
        <mxCell id="{p}e10" style="{ES}" edge="1" source="{p}H" target="{p}D2" parent="1"/>
        <mxCell id="{p}e11" value="ไม่" style="{ES}" edge="1" source="{p}D2" target="{p}I" parent="1"/>
        <mxCell id="{p}e12" value="ใช่" style="{ES}" edge="1" source="{p}D2" target="{p}DB2" parent="1"/>
        <mxCell id="{p}e13" style="{ES}" edge="1" source="{p}I" target="{p}J" parent="1"/>
        <mxCell id="{p}e14" style="{ES}" edge="1" source="{p}DB2" target="{p}J" parent="1"/>
        <mxCell id="{p}e15" style="{ES}" edge="1" source="{p}J" target="{p}E" parent="1"/>
      </root>
    </mxGraphModel>
  </diagram>
'''


def readonly(p, title, actor, ap, menu, display, dbfetch):
    """Read-only pattern: login → select menu → fetch DB → display → return"""
    return f'''  <diagram name="{title}" id="{p}">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        <mxCell id="{p}t" value="{title}" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=14;fontStyle=1;" vertex="1" parent="1"><mxGeometry x="130" y="10" width="340" height="30" as="geometry"/></mxCell>
        <mxCell id="{p}L1" value="{actor}" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="660" as="geometry"/></mxCell>
        <mxCell id="{p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="660" as="geometry"/></mxCell>
        <mxCell id="{p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="660" as="geometry"/></mxCell>
        <mxCell id="{p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;" vertex="1" parent="{p}L1"><mxGeometry x="95" y="40" width="30" height="30" as="geometry"/></mxCell>
        <mxCell id="{p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L1"><mxGeometry x="30" y="90" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}B" value="login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L1"><mxGeometry x="30" y="160" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;" vertex="1" parent="{p}L2"><mxGeometry x="30" y="130" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{p}C" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="20" y="255" width="180" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}DB1" value="ดึงข้อมูล" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L3"><mxGeometry x="30" y="245" width="100" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}F" value="{ap}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="10" y="330" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}G" value="{menu}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="5" y="400" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}DB2" value="{dbfetch}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L3"><mxGeometry x="20" y="400" width="120" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}SY" value="ประมวลผล/แสดงผล" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L2"><mxGeometry x="10" y="470" width="140" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}H" value="{display}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="5" y="475" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}J" value="กลับไปหน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L1"><mxGeometry x="30" y="555" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}E" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#FFFFFF;strokeWidth=3;" vertex="1" parent="{p}L1"><mxGeometry x="93" y="615" width="34" height="34" as="geometry"/></mxCell>
        <mxCell id="{p}e1" style="{ES}" edge="1" source="{p}S" target="{p}A" parent="1"/>
        <mxCell id="{p}e2" style="{ES}" edge="1" source="{p}A" target="{p}B" parent="1"/>
        <mxCell id="{p}e3" style="{ES}" edge="1" source="{p}B" target="{p}D1" parent="1"/>
        <mxCell id="{p}e4" value="ไม่" style="{ES}" edge="1" source="{p}D1" target="{p}C" parent="1"/>
        <mxCell id="{p}e5" value="ใช่" style="{ES}" edge="1" source="{p}D1" target="{p}DB1" parent="1"/>
        <mxCell id="{p}e6" style="{ES}" edge="1" source="{p}C" target="{p}B" parent="1"/>
        <mxCell id="{p}e7" style="{ES}" edge="1" source="{p}DB1" target="{p}F" parent="1"/>
        <mxCell id="{p}e8" style="{ES}" edge="1" source="{p}F" target="{p}G" parent="1"/>
        <mxCell id="{p}e9" style="{ES}" edge="1" source="{p}G" target="{p}DB2" parent="1"/>
        <mxCell id="{p}e10" style="{ES}" edge="1" source="{p}DB2" target="{p}SY" parent="1"/>
        <mxCell id="{p}e11" style="{ES}" edge="1" source="{p}SY" target="{p}H" parent="1"/>
        <mxCell id="{p}e12" style="{ES}" edge="1" source="{p}H" target="{p}J" parent="1"/>
        <mxCell id="{p}e13" style="{ES}" edge="1" source="{p}J" target="{p}E" parent="1"/>
      </root>
    </mxGraphModel>
  </diagram>
'''


def report_pdf(p, title, actor, ap, menu, select_text, dbfetch):
    """Report PDF pattern: login → select report → fetch DB → display → export PDF → download"""
    return f'''  <diagram name="{title}" id="{p}">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        <mxCell id="{p}t" value="{title}" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=14;fontStyle=1;" vertex="1" parent="1"><mxGeometry x="130" y="10" width="340" height="30" as="geometry"/></mxCell>
        <mxCell id="{p}L1" value="{actor}" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="800" as="geometry"/></mxCell>
        <mxCell id="{p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="800" as="geometry"/></mxCell>
        <mxCell id="{p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="800" as="geometry"/></mxCell>
        <mxCell id="{p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;" vertex="1" parent="{p}L1"><mxGeometry x="95" y="40" width="30" height="30" as="geometry"/></mxCell>
        <mxCell id="{p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L1"><mxGeometry x="30" y="90" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}B" value="login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L1"><mxGeometry x="30" y="155" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;" vertex="1" parent="{p}L2"><mxGeometry x="30" y="125" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{p}C" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="20" y="245" width="180" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}DB1" value="ดึงข้อมูล" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L3"><mxGeometry x="30" y="235" width="100" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}F" value="{ap}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="10" y="320" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}G" value="{menu}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="5" y="390" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}H" value="{select_text}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;" vertex="1" parent="{p}L1"><mxGeometry x="5" y="460" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{p}DB2" value="{dbfetch}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L3"><mxGeometry x="15" y="460" width="130" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}I" value="แสดงรายงาน" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L1"><mxGeometry x="30" y="540" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}K" value="กดส่งออก PDF" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L1"><mxGeometry x="30" y="610" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}SY" value="สร้างไฟล์ PDF" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L2"><mxGeometry x="15" y="610" width="130" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}M" value="ดาวน์โหลดสำเร็จ&#xa;กลับไปหน้ารายงาน" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="10" y="685" width="200" height="45" as="geometry"/></mxCell>
        <mxCell id="{p}E" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#FFFFFF;strokeWidth=3;" vertex="1" parent="{p}L1"><mxGeometry x="93" y="750" width="34" height="34" as="geometry"/></mxCell>
        <mxCell id="{p}e1" style="{ES}" edge="1" source="{p}S" target="{p}A" parent="1"/>
        <mxCell id="{p}e2" style="{ES}" edge="1" source="{p}A" target="{p}B" parent="1"/>
        <mxCell id="{p}e3" style="{ES}" edge="1" source="{p}B" target="{p}D1" parent="1"/>
        <mxCell id="{p}e4" value="ไม่" style="{ES}" edge="1" source="{p}D1" target="{p}C" parent="1"/>
        <mxCell id="{p}e5" value="ใช่" style="{ES}" edge="1" source="{p}D1" target="{p}DB1" parent="1"/>
        <mxCell id="{p}e6" style="{ES}" edge="1" source="{p}C" target="{p}B" parent="1"/>
        <mxCell id="{p}e7" style="{ES}" edge="1" source="{p}DB1" target="{p}F" parent="1"/>
        <mxCell id="{p}e8" style="{ES}" edge="1" source="{p}F" target="{p}G" parent="1"/>
        <mxCell id="{p}e9" style="{ES}" edge="1" source="{p}G" target="{p}H" parent="1"/>
        <mxCell id="{p}e10" style="{ES}" edge="1" source="{p}H" target="{p}DB2" parent="1"/>
        <mxCell id="{p}e11" style="{ES}" edge="1" source="{p}DB2" target="{p}I" parent="1"/>
        <mxCell id="{p}e12" style="{ES}" edge="1" source="{p}I" target="{p}K" parent="1"/>
        <mxCell id="{p}e13" style="{ES}" edge="1" source="{p}K" target="{p}SY" parent="1"/>
        <mxCell id="{p}e14" style="{ES}" edge="1" source="{p}SY" target="{p}M" parent="1"/>
        <mxCell id="{p}e15" style="{ES}" edge="1" source="{p}M" target="{p}E" parent="1"/>
      </root>
    </mxGraphModel>
  </diagram>
'''


def login_logout(p, title):
    """Login/Logout activity diagram"""
    return f'''  <diagram name="{title}" id="{p}">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        <mxCell id="{p}t" value="{title}" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=14;fontStyle=1;" vertex="1" parent="1"><mxGeometry x="130" y="10" width="340" height="30" as="geometry"/></mxCell>
        <mxCell id="{p}L1" value="ผู้ใช้งาน" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="740" as="geometry"/></mxCell>
        <mxCell id="{p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="740" as="geometry"/></mxCell>
        <mxCell id="{p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="740" as="geometry"/></mxCell>
        <mxCell id="{p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;" vertex="1" parent="{p}L1"><mxGeometry x="95" y="40" width="30" height="30" as="geometry"/></mxCell>
        <mxCell id="{p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L1"><mxGeometry x="30" y="90" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}B" value="กรอกชื่อผู้ใช้&#xa;และรหัสผ่าน" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="30" y="160" width="160" height="45" as="geometry"/></mxCell>
        <mxCell id="{p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;" vertex="1" parent="{p}L2"><mxGeometry x="30" y="130" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{p}C" value="แจ้งเตือนข้อมูลไม่ถูกต้อง&#xa;กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;" vertex="1" parent="{p}L1"><mxGeometry x="5" y="260" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{p}DB1" value="ดึงข้อมูลผู้ใช้&#xa;สร้าง Session" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L3"><mxGeometry x="15" y="245" width="130" height="45" as="geometry"/></mxCell>
        <mxCell id="{p}F" value="หน้าแรกตามบทบาท&#xa;(Admin/Instructor/Student)" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;" vertex="1" parent="{p}L1"><mxGeometry x="5" y="355" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{p}G" value="ใช้งานระบบตามบทบาท" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="10" y="435" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}H" value="กดออกจากระบบ (Logout)" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="10" y="510" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}SY" value="ลบ Session" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;" vertex="1" parent="{p}L2"><mxGeometry x="25" y="510" width="110" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}DB2" value="อัปเดต&#xa;Last Login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L3"><mxGeometry x="25" y="510" width="110" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}I" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;" vertex="1" parent="{p}L1"><mxGeometry x="20" y="600" width="180" height="40" as="geometry"/></mxCell>
        <mxCell id="{p}E" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#FFFFFF;strokeWidth=3;" vertex="1" parent="{p}L1"><mxGeometry x="93" y="670" width="34" height="34" as="geometry"/></mxCell>
        <mxCell id="{p}e1" style="{ES}" edge="1" source="{p}S" target="{p}A" parent="1"/>
        <mxCell id="{p}e2" style="{ES}" edge="1" source="{p}A" target="{p}B" parent="1"/>
        <mxCell id="{p}e3" style="{ES}" edge="1" source="{p}B" target="{p}D1" parent="1"/>
        <mxCell id="{p}e4" value="ไม่" style="{ES}" edge="1" source="{p}D1" target="{p}C" parent="1"/>
        <mxCell id="{p}e5" value="ใช่" style="{ES}" edge="1" source="{p}D1" target="{p}DB1" parent="1"/>
        <mxCell id="{p}e6" style="{ES}" edge="1" source="{p}C" target="{p}B" parent="1"/>
        <mxCell id="{p}e7" style="{ES}" edge="1" source="{p}DB1" target="{p}F" parent="1"/>
        <mxCell id="{p}e8" style="{ES}" edge="1" source="{p}F" target="{p}G" parent="1"/>
        <mxCell id="{p}e9" style="{ES}" edge="1" source="{p}G" target="{p}H" parent="1"/>
        <mxCell id="{p}e10" style="{ES}" edge="1" source="{p}H" target="{p}SY" parent="1"/>
        <mxCell id="{p}e11" style="{ES}" edge="1" source="{p}SY" target="{p}DB2" parent="1"/>
        <mxCell id="{p}e12" style="{ES}" edge="1" source="{p}DB2" target="{p}I" parent="1"/>
        <mxCell id="{p}e13" style="{ES}" edge="1" source="{p}I" target="{p}E" parent="1"/>
      </root>
    </mxGraphModel>
  </diagram>
'''


def main():
    pages = []

    # ========================================
    # 1. ผู้ดูแลระบบ (Administrator) - 8 diagrams
    # ========================================

    # 1.1 จัดการบัญชีผู้ใช้
    pages.append(crud("p01", "จัดการบัญชีผู้ใช้",
        actor="Administrator",
        ap="หน้าแรก Administrator",
        menu="เลือกเมนูจัดการบัญชีผู้ใช้",
        action="เลือกผู้ใช้/กำหนดสิทธิ์",
        err="หากไม่สามารถกำหนดสิทธิ์ได้ ระบบจะแจ้งเตือน",
        ret="กลับไปหน้าจัดการบัญชีผู้ใช้",
        dbsave="เก็บข้อมูล"))

    # 1.2 จัดการข้อมูลภาคเรียน
    pages.append(crud("p02", "จัดการข้อมูลภาคเรียน",
        actor="Administrator",
        ap="หน้าแรก Administrator",
        menu="เลือกเมนูจัดการภาคเรียน",
        action="เพิ่ม/แก้ไข/ลบ ข้อมูลภาคเรียน",
        err="หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน",
        ret="กลับไปหน้าจัดการภาคเรียน",
        dbsave="เก็บข้อมูล\nภาคเรียน"))

    # 1.3 จัดการข้อมูลห้องเรียน
    pages.append(crud("p03", "จัดการข้อมูลห้องเรียน",
        actor="Administrator",
        ap="หน้าแรก Administrator",
        menu="เลือกเมนูจัดการห้องเรียน",
        action="เพิ่ม/แก้ไข/ลบ ข้อมูลห้องเรียน",
        err="หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน",
        ret="กลับไปหน้าจัดการห้องเรียน",
        dbsave="เก็บข้อมูล\nห้องเรียน"))

    # 1.4 จัดการข้อมูลรายวิชา
    pages.append(crud("p04", "จัดการข้อมูลรายวิชา",
        actor="Administrator",
        ap="หน้าแรก Administrator",
        menu="เลือกเมนูจัดการรายวิชา",
        action="เพิ่ม/แก้ไข/ลบ ข้อมูลรายวิชา",
        err="หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน",
        ret="กลับไปหน้าจัดการรายวิชา",
        dbsave="เก็บข้อมูล\nรายวิชา"))

    # 1.5 จัดการข้อมูลนักศึกษา
    pages.append(crud("p05", "จัดการข้อมูลนักศึกษา",
        actor="Administrator",
        ap="หน้าแรก Administrator",
        menu="เลือกเมนูจัดการนักศึกษา",
        action="เพิ่ม/แก้ไข/ลบ ข้อมูลนักศึกษา",
        err="หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน",
        ret="กลับไปหน้าจัดการนักศึกษา",
        dbsave="เก็บข้อมูล\nนักศึกษา"))

    # 1.6 จัดการตารางเรียน/ตารางสอน
    pages.append(crud("p06", "จัดการตารางเรียน/ตารางสอน",
        actor="Administrator",
        ap="หน้าแรก Administrator",
        menu="เลือกเมนูจัดการตารางเรียน/สอน",
        action="เพิ่ม/แก้ไข/ลบ ตารางเรียน\nเลือก วิชา/ห้อง/เวลา/อาจารย์",
        err="หากข้อมูลซ้ำซ้อนหรือไม่ถูกต้อง ระบบจะแจ้งเตือน",
        ret="กลับไปหน้าจัดการตาราง",
        dbsave="เก็บข้อมูล\nตารางเรียน"))

    # 1.7 แดชบอร์ดสรุปข้อมูล
    pages.append(readonly("p07", "แดชบอร์ดสรุปข้อมูล (Admin)",
        actor="Administrator",
        ap="หน้าแรก Administrator",
        menu="เลือกเมนูแดชบอร์ด",
        display="แสดงสรุปข้อมูล\nเวลาเรียน/การเข้า/การขาด",
        dbfetch="ดึงข้อมูลสรุป\nการเข้าเรียน"))

    # 1.8 ส่งออกรายงาน PDF
    pages.append(report_pdf("p08", "ส่งออกรายงาน PDF (Admin)",
        actor="Administrator",
        ap="หน้าแรก Administrator",
        menu="เลือกเมนูรายงาน",
        select_text="เลือกประเภทรายงาน\n(ผู้ใช้/รายวิชา/ห้องเรียน/\nผลเข้าเรียน/ตาราง)",
        dbfetch="ดึงข้อมูล\nรายงาน"))

    # ========================================
    # 2. อาจารย์ (Instructor) - 7 diagrams
    # ========================================

    # 2.1 บันทึกเวลาเรียนเข้านักศึกษา
    pages.append(crud("p09", "บันทึกเวลาเรียนเข้านักศึกษา",
        actor="Instructor",
        ap="หน้าแรก Instructor",
        menu="เลือกเมนูบันทึกเวลาเรียน",
        action="เลือกรายวิชา/ห้องเรียน\nเลือกนักศึกษา กำหนดสถานะ\n(มา/ขาด/สาย)",
        err="หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน",
        ret="กลับไปหน้าบันทึกเวลาเรียน",
        dbsave="เก็บข้อมูล\nการเข้าเรียน"))

    # 2.2 เรียกดูรายวิชาที่สอน
    pages.append(readonly("p10", "เรียกดูรายวิชาที่สอน",
        actor="Instructor",
        ap="หน้าแรก Instructor",
        menu="เลือกเมนูรายวิชาที่สอน",
        display="แสดงรายวิชาที่สอน\nในภาคเรียนปัจจุบัน",
        dbfetch="ดึงข้อมูล\nรายวิชา"))

    # 2.3 จัดการข้อมูลนักศึกษาในรายวิชา
    pages.append(crud("p11", "จัดการข้อมูลนักศึกษาในรายวิชา",
        actor="Instructor",
        ap="หน้าแรก Instructor",
        menu="เลือกเมนูจัดการนักศึกษา\nในรายวิชา",
        action="เพิ่ม/แก้ไข/ลบ/ค้นหา\nนักศึกษาในรายวิชา",
        err="หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน",
        ret="กลับไปหน้าจัดการนักศึกษา",
        dbsave="เก็บข้อมูล\nนักศึกษา"))

    # 2.4 ค้นหาข้อมูลนักศึกษาและรายวิชา
    pages.append(readonly("p12", "ค้นหาข้อมูลนักศึกษาและรายวิชา",
        actor="Instructor",
        ap="หน้าแรก Instructor",
        menu="เลือกเมนูค้นหาข้อมูล",
        display="แสดงผลการค้นหา\nนักศึกษา/รายวิชา",
        dbfetch="ค้นหาข้อมูล\nในฐานข้อมูล"))

    # 2.5 ส่งออกรายงาน PDF (Instructor)
    pages.append(report_pdf("p13", "ส่งออกรายงาน PDF (Instructor)",
        actor="Instructor",
        ap="หน้าแรก Instructor",
        menu="เลือกเมนูรายงาน",
        select_text="เลือกรายวิชา/ห้องเรียน\nสรุปผลการเข้าเรียน",
        dbfetch="ดึงข้อมูล\nผลการเข้าเรียน"))

    # 2.6 ดูตารางสอน
    pages.append(readonly("p14", "ดูตารางสอน",
        actor="Instructor",
        ap="หน้าแรก Instructor",
        menu="เลือกเมนูตารางสอน",
        display="แสดงตารางสอน\nของอาจารย์",
        dbfetch="ดึงข้อมูล\nตารางสอน"))

    # 2.7 ส่งข้อความตอบกลับถึงนักศึกษา
    pages.append(crud("p15", "ส่งข้อความตอบกลับถึงนักศึกษา",
        actor="Instructor",
        ap="หน้าแรก Instructor",
        menu="เลือกเมนูข้อความ",
        action="เลือกนักศึกษาที่ต้องการ\nส่งข้อความถึง\nพิมพ์ข้อความ กดส่ง",
        err="หากข้อมูลไม่ครบ ระบบจะแจ้งเตือน",
        ret="กลับไปหน้าข้อความ",
        dbsave="เก็บข้อความ"))

    # ========================================
    # 3. นักศึกษา (Student) - 4 diagrams
    # ========================================

    # 3.1 แดชบอร์ดสรุปผลการเข้าห้องเรียน
    pages.append(readonly("p16", "แดชบอร์ดสรุปผลการเข้าห้องเรียน",
        actor="Student",
        ap="หน้าแรก Student",
        menu="เลือกเมนูแดชบอร์ด",
        display="แสดงสรุปผลการเข้าเรียน\nมา/ขาด/สาย",
        dbfetch="ดึงข้อมูล\nการเข้าเรียน"))

    # 3.2 ส่งออกรายงาน PDF (Student)
    pages.append(report_pdf("p17", "ส่งออกรายงาน PDF (Student)",
        actor="Student",
        ap="หน้าแรก Student",
        menu="เลือกเมนูรายงาน",
        select_text="เลือกรายวิชา\nดูสรุปผลการเข้าเรียน",
        dbfetch="ดึงข้อมูล\nผลการเข้าเรียน"))

    # 3.3 ดูตารางเรียน
    pages.append(readonly("p18", "ดูตารางเรียน",
        actor="Student",
        ap="หน้าแรก Student",
        menu="เลือกเมนูตารางเรียน",
        display="แสดงตารางเรียน\nของนักศึกษา",
        dbfetch="ดึงข้อมูล\nตารางเรียน"))

    # 3.4 ส่งข้อความถึงอาจารย์ผู้สอน
    pages.append(crud("p19", "ส่งข้อความถึงอาจารย์ผู้สอน",
        actor="Student",
        ap="หน้าแรก Student",
        menu="เลือกเมนูข้อความ",
        action="เลือกอาจารย์ที่ต้องการ\nส่งข้อความถึง\nพิมพ์ข้อความ กดส่ง",
        err="หากข้อมูลไม่ครบ ระบบจะแจ้งเตือน",
        ret="กลับไปหน้าข้อความ",
        dbsave="เก็บข้อความ"))

    # ========================================
    # 4. ฟังก์ชันร่วม (Shared) - 3 diagrams
    # ========================================

    # 4.1 เข้าสู่ระบบ/ออกจากระบบ
    pages.append(login_logout("p20", "เข้าสู่ระบบ/ออกจากระบบ"))

    # 4.2 อัปเดตโปรไฟล์
    pages.append(crud("p21", "อัปเดตโปรไฟล์",
        actor="ผู้ใช้งาน (ทุกบทบาท)",
        ap="หน้าแรกตามบทบาท",
        menu="เลือกเมนูโปรไฟล์",
        action="แก้ไขข้อมูลส่วนตัว\n(ชื่อ/อีเมล/เบอร์โทร)",
        err="หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน",
        ret="อัปเดตสำเร็จ กลับหน้าโปรไฟล์",
        dbsave="อัปเดต\nข้อมูลโปรไฟล์"))

    # 4.3 เปลี่ยนรหัสผ่าน
    pages.append(crud("p22", "เปลี่ยนรหัสผ่าน",
        actor="ผู้ใช้งาน (ทุกบทบาท)",
        ap="หน้าแรกตามบทบาท",
        menu="เลือกเมนูเปลี่ยนรหัสผ่าน",
        action="กรอกรหัสผ่านเดิม\nกรอกรหัสผ่านใหม่ และยืนยัน",
        err="หากรหัสผ่านไม่ถูกต้อง\nหรือไม่ตรงกัน ระบบแจ้งเตือน",
        ret="เปลี่ยนรหัสผ่านสำเร็จ กลับหน้าโปรไฟล์",
        dbsave="อัปเดต\nรหัสผ่าน"))

    # ========================================
    # Generate output file
    # ========================================
    os.makedirs('diagrams', exist_ok=True)

    xml = '<?xml version="1.0" encoding="UTF-8"?>\n'
    xml += '<mxfile host="app.diagrams.net" modified="2026-02-15T00:00:00.000Z" agent="draw.io" type="device">\n'
    for page in pages:
        xml += page
    xml += '</mxfile>\n'

    filepath = os.path.join('diagrams', 'activity_diagrams.drawio')
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(xml)

    print(f"✅ สร้างไฟล์สำเร็จ: {filepath}")
    print(f"📄 จำนวนหน้า: {len(pages)} Activity Diagrams")
    print()
    print("รายการ Activity Diagrams:")
    print("=" * 50)
    print()
    print("👨‍💼 ผู้ดูแลระบบ (Administrator)")
    print("  1. จัดการบัญชีผู้ใช้")
    print("  2. จัดการข้อมูลภาคเรียน")
    print("  3. จัดการข้อมูลห้องเรียน")
    print("  4. จัดการข้อมูลรายวิชา")
    print("  5. จัดการข้อมูลนักศึกษา")
    print("  6. จัดการตารางเรียน/ตารางสอน")
    print("  7. แดชบอร์ดสรุปข้อมูล")
    print("  8. ส่งออกรายงาน PDF")
    print()
    print("👨‍🏫 อาจารย์ (Instructor)")
    print("  9.  บันทึกเวลาเรียนเข้านักศึกษา")
    print("  10. เรียกดูรายวิชาที่สอน")
    print("  11. จัดการข้อมูลนักศึกษาในรายวิชา")
    print("  12. ค้นหาข้อมูลนักศึกษาและรายวิชา")
    print("  13. ส่งออกรายงาน PDF")
    print("  14. ดูตารางสอน")
    print("  15. ส่งข้อความตอบกลับถึงนักศึกษา")
    print()
    print("👨‍🎓 นักศึกษา (Student)")
    print("  16. แดชบอร์ดสรุปผลการเข้าห้องเรียน")
    print("  17. ส่งออกรายงาน PDF")
    print("  18. ดูตารางเรียน")
    print("  19. ส่งข้อความถึงอาจารย์ผู้สอน")
    print()
    print("👥 ฟังก์ชันร่วม (ทุกบทบาท)")
    print("  20. เข้าสู่ระบบ/ออกจากระบบ")
    print("  21. อัปเดตโปรไฟล์")
    print("  22. เปลี่ยนรหัสผ่าน")
    print()
    print("📁 เปิดไฟล์ด้วย draw.io หรือ https://app.diagrams.net")


if __name__ == "__main__":
    main()
