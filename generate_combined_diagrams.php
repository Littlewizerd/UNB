<?php
/**
 * สร้าง Use Case Diagrams และ Activity Diagrams รวมกัน
 * ระบบบันทึกเวลาเรียนของนักศึกษา
 * ไม่มีสี + End State ถูกต้อง + Database เป็นกล่องเหลี่ยม
 */

// =============================================
// USE CASE DIAGRAMS (3 pages) - ไม่มีสี
// =============================================

function usecase_student() {
    return <<<XML
  <diagram name="Use Case - นักศึกษา (Student)" id="uc01">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        
        <!-- Title -->
        <mxCell id="uc01title" value="Use Case Diagram: นักศึกษา (Student)" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=16;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="180" y="20" width="350" height="30" as="geometry"/>
        </mxCell>
        
        <!-- System Boundary -->
        <mxCell id="uc01sys" value="ระบบบันทึกเวลาเรียนของนักศึกษา" style="shape=umlFrame;whiteSpace=wrap;html=1;pointerEvents=0;width=280;height=30;fillColor=none;strokeColor=#000000;strokeWidth=1;fontStyle=1;fontSize=13;" vertex="1" parent="1">
          <mxGeometry x="160" y="70" width="400" height="600" as="geometry"/>
        </mxCell>
        
        <!-- Actor -->
        <mxCell id="uc01actor" value="นักศึกษา" style="shape=umlActor;verticalLabelPosition=bottom;verticalAlign=top;html=1;outlineConnect=0;strokeWidth=1;fontSize=12;" vertex="1" parent="1">
          <mxGeometry x="40" y="300" width="60" height="100" as="geometry"/>
        </mxCell>
        
        <!-- Use Cases -->
        <mxCell id="uc01u1" value="เข้าสู่ระบบ/ออกจากระบบ" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="230" y="110" width="150" height="60" as="geometry"/>
        </mxCell>
        <mxCell id="uc01u2" value="อัปเดตโปรไฟล์" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="230" y="190" width="150" height="60" as="geometry"/>
        </mxCell>
        <mxCell id="uc01u3" value="เปลี่ยนรหัสผ่าน" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="230" y="270" width="150" height="60" as="geometry"/>
        </mxCell>
        <mxCell id="uc01u4" value="แดชบอร์ดสรุปผลการเข้าเรียน" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="230" y="350" width="150" height="60" as="geometry"/>
        </mxCell>
        <mxCell id="uc01u5" value="ส่งออกรายงาน PDF" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="230" y="430" width="150" height="60" as="geometry"/>
        </mxCell>
        <mxCell id="uc01u6" value="ดูตารางเรียน" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="230" y="510" width="150" height="60" as="geometry"/>
        </mxCell>
        <mxCell id="uc01u7" value="ส่งข้อความถึงอาจารย์ผู้สอน" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="230" y="590" width="150" height="60" as="geometry"/>
        </mxCell>
        
        <!-- Associations -->
        <mxCell id="uc01e1" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc01actor" target="uc01u1"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc01e2" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc01actor" target="uc01u2"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc01e3" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc01actor" target="uc01u3"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc01e4" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc01actor" target="uc01u4"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc01e5" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc01actor" target="uc01u5"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc01e6" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc01actor" target="uc01u6"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc01e7" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc01actor" target="uc01u7"><mxGeometry relative="1" as="geometry"/></mxCell>
      </root>
    </mxGraphModel>
  </diagram>

XML;
}

function usecase_instructor() {
    return <<<XML
  <diagram name="Use Case - อาจารย์ (Instructor)" id="uc02">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        
        <!-- Title -->
        <mxCell id="uc02title" value="Use Case Diagram: อาจารย์ (Instructor)" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=16;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="180" y="20" width="370" height="30" as="geometry"/>
        </mxCell>
        
        <!-- System Boundary -->
        <mxCell id="uc02sys" value="ระบบบันทึกเวลาเรียนของนักศึกษา" style="shape=umlFrame;whiteSpace=wrap;html=1;pointerEvents=0;width=280;height=30;fillColor=none;strokeColor=#000000;strokeWidth=1;fontStyle=1;fontSize=13;" vertex="1" parent="1">
          <mxGeometry x="160" y="60" width="450" height="780" as="geometry"/>
        </mxCell>
        
        <!-- Actor -->
        <mxCell id="uc02actor" value="อาจารย์" style="shape=umlActor;verticalLabelPosition=bottom;verticalAlign=top;html=1;outlineConnect=0;strokeWidth=1;fontSize=12;" vertex="1" parent="1">
          <mxGeometry x="40" y="370" width="60" height="100" as="geometry"/>
        </mxCell>
        
        <!-- Use Cases -->
        <mxCell id="uc02u1" value="เข้าสู่ระบบ/ออกจากระบบ" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="260" y="100" width="150" height="55" as="geometry"/>
        </mxCell>
        <mxCell id="uc02u2" value="อัปเดตโปรไฟล์" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="260" y="170" width="150" height="55" as="geometry"/>
        </mxCell>
        <mxCell id="uc02u3" value="เปลี่ยนรหัสผ่าน" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="260" y="240" width="150" height="55" as="geometry"/>
        </mxCell>
        <mxCell id="uc02u4" value="บันทึกเวลาเข้าห้องเรียน" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="260" y="310" width="150" height="55" as="geometry"/>
        </mxCell>
        <mxCell id="uc02u5" value="เรียกดูรายวิชาที่สอน" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="260" y="380" width="150" height="55" as="geometry"/>
        </mxCell>
        <mxCell id="uc02u6" value="จัดการข้อมูลนักศึกษาในรายวิชา" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=10;" vertex="1" parent="1">
          <mxGeometry x="260" y="450" width="160" height="55" as="geometry"/>
        </mxCell>
        <mxCell id="uc02u7" value="ค้นหาข้อมูล" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="260" y="520" width="150" height="55" as="geometry"/>
        </mxCell>
        <mxCell id="uc02u8" value="ส่งออกรายงาน PDF" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="260" y="590" width="150" height="55" as="geometry"/>
        </mxCell>
        <mxCell id="uc02u9" value="ดูตารางสอน" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="260" y="660" width="150" height="55" as="geometry"/>
        </mxCell>
        <mxCell id="uc02u10" value="ส่งข้อความตอบกลับนักศึกษา" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=10;" vertex="1" parent="1">
          <mxGeometry x="260" y="730" width="160" height="55" as="geometry"/>
        </mxCell>
        
        <!-- Associations -->
        <mxCell id="uc02e1" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc02actor" target="uc02u1"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc02e2" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc02actor" target="uc02u2"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc02e3" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc02actor" target="uc02u3"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc02e4" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc02actor" target="uc02u4"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc02e5" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc02actor" target="uc02u5"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc02e6" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc02actor" target="uc02u6"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc02e7" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc02actor" target="uc02u7"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc02e8" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc02actor" target="uc02u8"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc02e9" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc02actor" target="uc02u9"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc02e10" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc02actor" target="uc02u10"><mxGeometry relative="1" as="geometry"/></mxCell>
      </root>
    </mxGraphModel>
  </diagram>

XML;
}

function usecase_admin() {
    return <<<XML
  <diagram name="Use Case - ผู้ดูแลระบบ (Administrator)" id="uc03">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        
        <!-- Title -->
        <mxCell id="uc03title" value="Use Case Diagram: ผู้ดูแลระบบ (Administrator)" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=16;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="150" y="10" width="400" height="30" as="geometry"/>
        </mxCell>
        
        <!-- System Boundary -->
        <mxCell id="uc03sys" value="ระบบบันทึกเวลาเรียนของนักศึกษา" style="shape=umlFrame;whiteSpace=wrap;html=1;pointerEvents=0;width=280;height=30;fillColor=none;strokeColor=#000000;strokeWidth=1;fontStyle=1;fontSize=13;" vertex="1" parent="1">
          <mxGeometry x="130" y="50" width="540" height="960" as="geometry"/>
        </mxCell>
        
        <!-- Actor -->
        <mxCell id="uc03actor" value="Administrator" style="shape=umlActor;verticalLabelPosition=bottom;verticalAlign=top;html=1;outlineConnect=0;strokeWidth=1;fontSize=12;" vertex="1" parent="1">
          <mxGeometry x="25" y="450" width="60" height="100" as="geometry"/>
        </mxCell>
        
        <!-- Use Cases -->
        <mxCell id="uc03u1" value="เข้าสู่ระบบ/ออกจากระบบ" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="200" y="85" width="150" height="50" as="geometry"/>
        </mxCell>
        <mxCell id="uc03u2" value="อัปเดตโปรไฟล์" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="200" y="145" width="150" height="50" as="geometry"/>
        </mxCell>
        <mxCell id="uc03u3" value="เปลี่ยนรหัสผ่าน" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="200" y="205" width="150" height="50" as="geometry"/>
        </mxCell>
        <mxCell id="uc03u4" value="แดชบอร์ดสรุปข้อมูล" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="200" y="265" width="150" height="50" as="geometry"/>
        </mxCell>
        <mxCell id="uc03u5" value="จัดการบัญชีผู้ใช้" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="200" y="330" width="150" height="50" as="geometry"/>
        </mxCell>
        <mxCell id="uc03u6" value="จัดการข้อมูลภาคเรียน" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="200" y="390" width="150" height="50" as="geometry"/>
        </mxCell>
        <mxCell id="uc03u7" value="จัดการข้อมูลห้องเรียน" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="200" y="450" width="150" height="50" as="geometry"/>
        </mxCell>
        <mxCell id="uc03u8" value="จัดการข้อมูลรายวิชา" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="200" y="510" width="150" height="50" as="geometry"/>
        </mxCell>
        <mxCell id="uc03u9" value="จัดการข้อมูลนักศึกษา" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="200" y="570" width="150" height="50" as="geometry"/>
        </mxCell>
        <mxCell id="uc03u10" value="จัดการตารางเรียน/ตารางสอน" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=10;" vertex="1" parent="1">
          <mxGeometry x="200" y="630" width="160" height="50" as="geometry"/>
        </mxCell>
        <mxCell id="uc03u11" value="รายงานบัญชีผู้ใช้ PDF" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=11;" vertex="1" parent="1">
          <mxGeometry x="200" y="700" width="150" height="50" as="geometry"/>
        </mxCell>
        <mxCell id="uc03u12" value="รายงานข้อมูลรายวิชา PDF" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=10;" vertex="1" parent="1">
          <mxGeometry x="200" y="760" width="160" height="50" as="geometry"/>
        </mxCell>
        <mxCell id="uc03u13" value="รายงานข้อมูลห้องเรียน PDF" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=10;" vertex="1" parent="1">
          <mxGeometry x="200" y="820" width="160" height="50" as="geometry"/>
        </mxCell>
        <mxCell id="uc03u14" value="รายงานผลการเข้าเรียน PDF" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=10;" vertex="1" parent="1">
          <mxGeometry x="200" y="880" width="160" height="50" as="geometry"/>
        </mxCell>
        <mxCell id="uc03u15" value="รายงานตารางเรียน/สอน PDF" style="ellipse;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;strokeWidth=1;fontSize=10;" vertex="1" parent="1">
          <mxGeometry x="200" y="940" width="160" height="50" as="geometry"/>
        </mxCell>
        
        <!-- Associations -->
        <mxCell id="uc03e1" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u1"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc03e2" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u2"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc03e3" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u3"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc03e4" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u4"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc03e5" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u5"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc03e6" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u6"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc03e7" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u7"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc03e8" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u8"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc03e9" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u9"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc03e10" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u10"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc03e11" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u11"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc03e12" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u12"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc03e13" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u13"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc03e14" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u14"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="uc03e15" style="endArrow=none;html=1;strokeWidth=1;strokeColor=#000000;" edge="1" parent="1" source="uc03actor" target="uc03u15"><mxGeometry relative="1" as="geometry"/></mxCell>
      </root>
    </mxGraphModel>
  </diagram>

XML;
}

// =============================================
// ACTIVITY DIAGRAMS - Database เป็นกล่องเหลี่ยมมุมโค้ง
// =============================================

function crud($p, $title, $actor, $ap, $menu, $action, $err, $ret, $dbsave) {
    return <<<XML
  <diagram name="{$title}" id="{$p}">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        <mxCell id="{$p}t" value="{$title}" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=14;fontStyle=1;" vertex="1" parent="1"><mxGeometry x="130" y="10" width="340" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}L1" value="{$actor}" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="780" as="geometry"/></mxCell>
        <mxCell id="{$p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="780" as="geometry"/></mxCell>
        <mxCell id="{$p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="780" as="geometry"/></mxCell>
        
        <!-- Start: วงกลมดำทึบ -->
        <mxCell id="{$p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="125" y="80" width="30" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="60" y="130" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}B" value="login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="60" y="200" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="280" y="170" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}C" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="50" y="295" width="180" height="40" as="geometry"/></mxCell>
        
        <!-- Database เป็นกล่องเหลี่ยม -->
        <mxCell id="{$p}DB1" value="ดึงข้อมูล" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="430" y="275" width="120" height="40" as="geometry"/></mxCell>
        
        <mxCell id="{$p}F" value="{$ap}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="40" y="370" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}G" value="{$menu}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="35" y="440" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}H" value="{$action}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="35" y="510" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}D2" value="บันทึก" style="rhombus;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="280" y="490" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}I" value="{$err}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="35" y="605" width="210" height="45" as="geometry"/></mxCell>
        
        <!-- Database เป็นกล่องเหลี่ยม -->
        <mxCell id="{$p}DB2" value="{$dbsave}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="430" y="590" width="120" height="45" as="geometry"/></mxCell>
        
        <mxCell id="{$p}J" value="{$ret}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="35" y="685" width="210" height="40" as="geometry"/></mxCell>
        
        <!-- End State: วงกลมขาวมีขอบดำ ข้างในมีวงกลมดำเล็ก -->
        <mxCell id="{$p}Eo" value="" style="ellipse;html=1;aspect=fixed;fillColor=#FFFFFF;strokeColor=#000000;strokeWidth=2;" vertex="1" parent="1"><mxGeometry x="115" y="755" width="50" height="50" as="geometry"/></mxCell>
        <mxCell id="{$p}Ei" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="125" y="765" width="30" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}e1" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}S" target="{$p}A"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e2" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}A" target="{$p}B"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e3" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}B" target="{$p}D1"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e4" value="ไม่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}D1" target="{$p}C"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e5" value="ใช่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}D1" target="{$p}DB1"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e6" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;dashed=1;strokeColor=#000000;" edge="1" parent="1" source="{$p}C" target="{$p}B"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="30" y="315"/><mxPoint x="30" y="220"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e7" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}DB1" target="{$p}F"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="430" y="350"/><mxPoint x="140" y="350"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e8" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}F" target="{$p}G"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e9" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}G" target="{$p}H"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e10" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}H" target="{$p}D2"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e11" value="ไม่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}D2" target="{$p}I"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e12" value="ใช่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}D2" target="{$p}DB2"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e13" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}I" target="{$p}J"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e14" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=1;entryY=0.5;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}DB2" target="{$p}J"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="430" y="705"/><mxPoint x="245" y="705"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e15" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}J" target="{$p}Eo"><mxGeometry relative="1" as="geometry"/></mxCell>
      </root>
    </mxGraphModel>
  </diagram>

XML;
}


function readonly_page($p, $title, $actor, $ap, $menu, $display, $dbfetch) {
    return <<<XML
  <diagram name="{$title}" id="{$p}">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        <mxCell id="{$p}t" value="{$title}" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=14;fontStyle=1;" vertex="1" parent="1"><mxGeometry x="130" y="10" width="340" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}L1" value="{$actor}" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="700" as="geometry"/></mxCell>
        <mxCell id="{$p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="700" as="geometry"/></mxCell>
        <mxCell id="{$p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="700" as="geometry"/></mxCell>
        
        <!-- Start: วงกลมดำทึบ -->
        <mxCell id="{$p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="125" y="80" width="30" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="60" y="130" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}B" value="login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="60" y="200" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="280" y="170" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}C" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="50" y="295" width="180" height="40" as="geometry"/></mxCell>
        
        <!-- Database เป็นกล่องเหลี่ยม -->
        <mxCell id="{$p}DB1" value="ดึงข้อมูล" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="430" y="275" width="120" height="40" as="geometry"/></mxCell>
        
        <mxCell id="{$p}F" value="{$ap}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="40" y="370" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}G" value="{$menu}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="35" y="440" width="210" height="40" as="geometry"/></mxCell>
        
        <!-- Database เป็นกล่องเหลี่ยม -->
        <mxCell id="{$p}DB2" value="{$dbfetch}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="425" y="440" width="130" height="40" as="geometry"/></mxCell>
        
        <mxCell id="{$p}SY" value="ประมวลผล/แสดงผล" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="260" y="510" width="140" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}H" value="{$display}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="35" y="515" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}J" value="กลับไปหน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="60" y="595" width="160" height="40" as="geometry"/></mxCell>
        
        <!-- End State: วงกลมขาวมีขอบดำ ข้างในมีวงกลมดำเล็ก -->
        <mxCell id="{$p}Eo" value="" style="ellipse;html=1;aspect=fixed;fillColor=#FFFFFF;strokeColor=#000000;strokeWidth=2;" vertex="1" parent="1"><mxGeometry x="115" y="665" width="50" height="50" as="geometry"/></mxCell>
        <mxCell id="{$p}Ei" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="125" y="675" width="30" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}e1" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}S" target="{$p}A"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e2" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}A" target="{$p}B"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e3" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}B" target="{$p}D1"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e4" value="ไม่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}D1" target="{$p}C"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e5" value="ใช่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}D1" target="{$p}DB1"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e6" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;dashed=1;strokeColor=#000000;" edge="1" parent="1" source="{$p}C" target="{$p}B"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="30" y="315"/><mxPoint x="30" y="220"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e7" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}DB1" target="{$p}F"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="430" y="350"/><mxPoint x="140" y="350"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e8" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}F" target="{$p}G"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e9" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}G" target="{$p}DB2"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e10" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=1;entryY=0.5;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}DB2" target="{$p}SY"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e11" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=1;entryY=0.5;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}SY" target="{$p}H"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e12" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}H" target="{$p}J"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e13" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}J" target="{$p}Eo"><mxGeometry relative="1" as="geometry"/></mxCell>
      </root>
    </mxGraphModel>
  </diagram>

XML;
}

function report_pdf($p, $title, $actor, $ap, $menu, $select_text, $dbfetch) {
    return <<<XML
  <diagram name="{$title}" id="{$p}">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        <mxCell id="{$p}t" value="{$title}" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=14;fontStyle=1;" vertex="1" parent="1"><mxGeometry x="130" y="10" width="340" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}L1" value="{$actor}" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="840" as="geometry"/></mxCell>
        <mxCell id="{$p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="840" as="geometry"/></mxCell>
        <mxCell id="{$p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="840" as="geometry"/></mxCell>
        
        <!-- Start: วงกลมดำทึบ -->
        <mxCell id="{$p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="125" y="80" width="30" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="60" y="130" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}B" value="login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="60" y="195" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="280" y="165" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}C" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="50" y="285" width="180" height="40" as="geometry"/></mxCell>
        
        <!-- Database เป็นกล่องเหลี่ยม -->
        <mxCell id="{$p}DB1" value="ดึงข้อมูล" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="430" y="270" width="120" height="40" as="geometry"/></mxCell>
        
        <mxCell id="{$p}F" value="{$ap}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="40" y="360" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}G" value="{$menu}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="35" y="430" width="210" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}H" value="{$select_text}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="35" y="500" width="210" height="45" as="geometry"/></mxCell>
        
        <!-- Database เป็นกล่องเหลี่ยม -->
        <mxCell id="{$p}DB2" value="{$dbfetch}" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="420" y="495" width="140" height="40" as="geometry"/></mxCell>
        
        <mxCell id="{$p}I" value="แสดงรายงาน" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="60" y="580" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}K" value="กดส่งออก PDF" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="60" y="650" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}SY" value="สร้างไฟล์ PDF" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="265" y="650" width="130" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}M" value="ดาวน์โหลดสำเร็จ&#xa;กลับไปหน้ารายงาน" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="40" y="725" width="200" height="45" as="geometry"/></mxCell>
        
        <!-- End State: วงกลมขาวมีขอบดำ ข้างในมีวงกลมดำเล็ก -->
        <mxCell id="{$p}Eo" value="" style="ellipse;html=1;aspect=fixed;fillColor=#FFFFFF;strokeColor=#000000;strokeWidth=2;" vertex="1" parent="1"><mxGeometry x="115" y="800" width="50" height="50" as="geometry"/></mxCell>
        <mxCell id="{$p}Ei" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="125" y="810" width="30" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}e1" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}S" target="{$p}A"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e2" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}A" target="{$p}B"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e3" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}B" target="{$p}D1"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e4" value="ไม่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}D1" target="{$p}C"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e5" value="ใช่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}D1" target="{$p}DB1"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e6" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;dashed=1;strokeColor=#000000;" edge="1" parent="1" source="{$p}C" target="{$p}B"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="30" y="305"/><mxPoint x="30" y="215"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e7" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}DB1" target="{$p}F"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="430" y="345"/><mxPoint x="140" y="345"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e8" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}F" target="{$p}G"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e9" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}G" target="{$p}H"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e10" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}H" target="{$p}DB2"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e11" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}DB2" target="{$p}I"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="420" y="565"/><mxPoint x="140" y="565"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e12" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}I" target="{$p}K"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e13" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}K" target="{$p}SY"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e14" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}SY" target="{$p}M"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="265" y="710"/><mxPoint x="140" y="710"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e15" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}M" target="{$p}Eo"><mxGeometry relative="1" as="geometry"/></mxCell>
      </root>
    </mxGraphModel>
  </diagram>

XML;
}


function login_logout_page($p, $title) {
    return <<<XML
  <diagram name="{$title}" id="{$p}">
    <mxGraphModel dx="1422" dy="762" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169">
      <root>
        <mxCell id="0"/><mxCell id="1" parent="0"/>
        <mxCell id="{$p}t" value="{$title}" style="text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;fontSize=14;fontStyle=1;" vertex="1" parent="1"><mxGeometry x="130" y="10" width="340" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}L1" value="ผู้ใช้งาน" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="30" y="40" width="220" height="780" as="geometry"/></mxCell>
        <mxCell id="{$p}L2" value="System" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="250" y="40" width="160" height="780" as="geometry"/></mxCell>
        <mxCell id="{$p}L3" value="Database" style="shape=swimlane;startSize=25;html=1;fontStyle=1;collapsible=0;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="410" y="40" width="160" height="780" as="geometry"/></mxCell>
        
        <!-- Start: วงกลมดำทึบ -->
        <mxCell id="{$p}S" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="125" y="80" width="30" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}A" value="หน้าแรก" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="60" y="130" width="160" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}B" value="กรอกชื่อผู้ใช้&#xa;และรหัสผ่าน" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="60" y="200" width="160" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}D1" value="ตรวจสอบ" style="rhombus;whiteSpace=wrap;html=1;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="280" y="170" width="100" height="80" as="geometry"/></mxCell>
        <mxCell id="{$p}C" value="แจ้งเตือนข้อมูลไม่ถูกต้อง&#xa;กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="35" y="300" width="210" height="45" as="geometry"/></mxCell>
        
        <!-- Database เป็นกล่องเหลี่ยม -->
        <mxCell id="{$p}DB1" value="ดึงข้อมูลผู้ใช้&#xa;สร้าง Session" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="420" y="280" width="140" height="45" as="geometry"/></mxCell>
        
        <mxCell id="{$p}F" value="หน้าแรกตามบทบาท&#xa;(Admin/Instructor/Student)" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=9;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="35" y="395" width="210" height="45" as="geometry"/></mxCell>
        <mxCell id="{$p}G" value="ใช้งานระบบตามบทบาท" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="40" y="475" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}H" value="กดออกจากระบบ (Logout)" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="40" y="550" width="200" height="40" as="geometry"/></mxCell>
        <mxCell id="{$p}SY" value="ลบ Session" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="275" y="550" width="110" height="40" as="geometry"/></mxCell>
        
        <!-- Database เป็นกล่องเหลี่ยม -->
        <mxCell id="{$p}DB2" value="อัปเดต&#xa;Last Login" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="430" y="540" width="120" height="45" as="geometry"/></mxCell>
        
        <mxCell id="{$p}I" value="กลับไปหน้าเข้าสู่ระบบ" style="rounded=1;whiteSpace=wrap;html=1;arcSize=20;fontSize=10;fillColor=none;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="50" y="640" width="180" height="40" as="geometry"/></mxCell>
        
        <!-- End State: วงกลมขาวมีขอบดำ ข้างในมีวงกลมดำเล็ก -->
        <mxCell id="{$p}Eo" value="" style="ellipse;html=1;aspect=fixed;fillColor=#FFFFFF;strokeColor=#000000;strokeWidth=2;" vertex="1" parent="1"><mxGeometry x="115" y="715" width="50" height="50" as="geometry"/></mxCell>
        <mxCell id="{$p}Ei" value="" style="ellipse;html=1;aspect=fixed;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="125" y="725" width="30" height="30" as="geometry"/></mxCell>
        
        <mxCell id="{$p}e1" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}S" target="{$p}A"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e2" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}A" target="{$p}B"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e3" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}B" target="{$p}D1"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e4" value="ไม่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}D1" target="{$p}C"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e5" value="ใช่" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}D1" target="{$p}DB1"><mxGeometry relative="1" as="geometry"><mxPoint as="offset"/></mxGeometry></mxCell>
        <mxCell id="{$p}e6" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;dashed=1;strokeColor=#000000;" edge="1" parent="1" source="{$p}C" target="{$p}B"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="30" y="322"/><mxPoint x="30" y="222"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e7" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}DB1" target="{$p}F"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="420" y="370"/><mxPoint x="140" y="370"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e8" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}F" target="{$p}G"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e9" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}G" target="{$p}H"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e10" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}H" target="{$p}SY"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e11" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=1;exitY=0.5;entryX=0;entryY=0.5;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}SY" target="{$p}DB2"><mxGeometry relative="1" as="geometry"/></mxCell>
        <mxCell id="{$p}e12" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}DB2" target="{$p}I"><mxGeometry relative="1" as="geometry"><Array as="points"><mxPoint x="430" y="620"/><mxPoint x="140" y="620"/></Array></mxGeometry></mxCell>
        <mxCell id="{$p}e13" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;exitX=0.5;exitY=1;entryX=0.5;entryY=0;endArrow=classic;strokeColor=#000000;" edge="1" parent="1" source="{$p}I" target="{$p}Eo"><mxGeometry relative="1" as="geometry"/></mxCell>
      </root>
    </mxGraphModel>
  </diagram>

XML;
}

// =============================================
// สร้างทุกหน้า
// =============================================
$pages = [];

// Use Case Diagrams (3 pages)
$pages[] = usecase_student();
$pages[] = usecase_instructor();
$pages[] = usecase_admin();

// Activity Diagrams - Administrator (8 pages)
$pages[] = crud("p01", "Activity: จัดการบัญชีผู้ใช้", "Administrator", "หน้าแรก Administrator", "เลือกเมนูจัดการบัญชีผู้ใช้", "เลือกผู้ใช้/กำหนดสิทธิ์", "หากไม่สามารถกำหนดสิทธิ์ได้ ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการบัญชีผู้ใช้", "เก็บข้อมูล");
$pages[] = crud("p02", "Activity: จัดการข้อมูลภาคเรียน", "Administrator", "หน้าแรก Administrator", "เลือกเมนูจัดการภาคเรียน", "เพิ่ม/แก้ไข/ลบ ข้อมูลภาคเรียน", "หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการภาคเรียน", "เก็บข้อมูล&#xa;ภาคเรียน");
$pages[] = crud("p03", "Activity: จัดการข้อมูลห้องเรียน", "Administrator", "หน้าแรก Administrator", "เลือกเมนูจัดการห้องเรียน", "เพิ่ม/แก้ไข/ลบ ข้อมูลห้องเรียน", "หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการห้องเรียน", "เก็บข้อมูล&#xa;ห้องเรียน");
$pages[] = crud("p04", "Activity: จัดการข้อมูลรายวิชา", "Administrator", "หน้าแรก Administrator", "เลือกเมนูจัดการรายวิชา", "เพิ่ม/แก้ไข/ลบ ข้อมูลรายวิชา", "หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการรายวิชา", "เก็บข้อมูล&#xa;รายวิชา");
$pages[] = crud("p05", "Activity: จัดการข้อมูลนักศึกษา", "Administrator", "หน้าแรก Administrator", "เลือกเมนูจัดการนักศึกษา", "เพิ่ม/แก้ไข/ลบ ข้อมูลนักศึกษา", "หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการนักศึกษา", "เก็บข้อมูล&#xa;นักศึกษา");
$pages[] = crud("p06", "Activity: จัดการตารางเรียน/สอน", "Administrator", "หน้าแรก Administrator", "เลือกเมนูจัดการตารางเรียน/สอน", "เพิ่ม/แก้ไข/ลบ ตารางเรียน&#xa;เลือก วิชา/ห้อง/เวลา/อาจารย์", "หากข้อมูลซ้ำซ้อน ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการตาราง", "เก็บข้อมูล&#xa;ตารางเรียน");
$pages[] = readonly_page("p07", "Activity: แดชบอร์ดสรุปข้อมูล (Admin)", "Administrator", "หน้าแรก Administrator", "เลือกเมนูแดชบอร์ด", "แสดงสรุปข้อมูล&#xa;เวลาเรียน/การเข้า/การขาด", "ดึงข้อมูลสรุป&#xa;การเข้าเรียน");
$pages[] = report_pdf("p08", "Activity: ส่งออกรายงาน PDF (Admin)", "Administrator", "หน้าแรก Administrator", "เลือกเมนูรายงาน", "เลือกประเภทรายงาน&#xa;(ผู้ใช้/รายวิชา/ห้องเรียน/&#xa;ผลเข้าเรียน/ตาราง)", "ดึงข้อมูล&#xa;รายงาน");

// Activity Diagrams - Instructor (7 pages)
$pages[] = crud("p09", "Activity: บันทึกเวลาเรียนนักศึกษา", "Instructor", "หน้าแรก Instructor", "เลือกเมนูบันทึกเวลาเรียน", "เลือกรายวิชา/ห้องเรียน&#xa;กำหนดสถานะ (มา/ขาด/สาย)", "หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน", "กลับไปหน้าบันทึกเวลาเรียน", "เก็บข้อมูล&#xa;การเข้าเรียน");
$pages[] = readonly_page("p10", "Activity: เรียกดูรายวิชาที่สอน", "Instructor", "หน้าแรก Instructor", "เลือกเมนูรายวิชาที่สอน", "แสดงรายวิชาที่สอน&#xa;ในภาคเรียนปัจจุบัน", "ดึงข้อมูล&#xa;รายวิชา");
$pages[] = crud("p11", "Activity: จัดการนักศึกษาในรายวิชา", "Instructor", "หน้าแรก Instructor", "เลือกเมนูจัดการนักศึกษา&#xa;ในรายวิชา", "เพิ่ม/แก้ไข/ลบ/ค้นหา&#xa;นักศึกษาในรายวิชา", "หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน", "กลับไปหน้าจัดการนักศึกษา", "เก็บข้อมูล&#xa;นักศึกษา");
$pages[] = readonly_page("p12", "Activity: ค้นหาข้อมูล", "Instructor", "หน้าแรก Instructor", "เลือกเมนูค้นหาข้อมูล", "แสดงผลการค้นหา&#xa;นักศึกษา/รายวิชา", "ค้นหาข้อมูล&#xa;ในฐานข้อมูล");
$pages[] = report_pdf("p13", "Activity: ส่งออกรายงาน PDF (Instructor)", "Instructor", "หน้าแรก Instructor", "เลือกเมนูรายงาน", "เลือกรายวิชา/ห้องเรียน&#xa;สรุปผลการเข้าเรียน", "ดึงข้อมูล&#xa;ผลการเข้าเรียน");
$pages[] = readonly_page("p14", "Activity: ดูตารางสอน", "Instructor", "หน้าแรก Instructor", "เลือกเมนูตารางสอน", "แสดงตารางสอน&#xa;ของอาจารย์", "ดึงข้อมูล&#xa;ตารางสอน");
$pages[] = crud("p15", "Activity: ส่งข้อความถึงนักศึกษา", "Instructor", "หน้าแรก Instructor", "เลือกเมนูข้อความ", "เลือกนักศึกษาที่ต้องการ&#xa;ส่งข้อความถึง พิมพ์ข้อความ", "หากข้อมูลไม่ครบ ระบบจะแจ้งเตือน", "กลับไปหน้าข้อความ", "เก็บข้อความ");

// Activity Diagrams - Student (4 pages)
$pages[] = readonly_page("p16", "Activity: แดชบอร์ดผลการเข้าเรียน (Student)", "Student", "หน้าแรก Student", "เลือกเมนูแดชบอร์ด", "แสดงสรุปผลการเข้าเรียน&#xa;มา/ขาด/สาย", "ดึงข้อมูล&#xa;การเข้าเรียน");
$pages[] = report_pdf("p17", "Activity: ส่งออกรายงาน PDF (Student)", "Student", "หน้าแรก Student", "เลือกเมนูรายงาน", "เลือกรายวิชา&#xa;ดูสรุปผลการเข้าเรียน", "ดึงข้อมูล&#xa;ผลการเข้าเรียน");
$pages[] = readonly_page("p18", "Activity: ดูตารางเรียน", "Student", "หน้าแรก Student", "เลือกเมนูตารางเรียน", "แสดงตารางเรียน&#xa;ของนักศึกษา", "ดึงข้อมูล&#xa;ตารางเรียน");
$pages[] = crud("p19", "Activity: ส่งข้อความถึงอาจารย์", "Student", "หน้าแรก Student", "เลือกเมนูข้อความ", "เลือกอาจารย์ที่ต้องการ&#xa;ส่งข้อความถึง พิมพ์ข้อความ", "หากข้อมูลไม่ครบ ระบบจะแจ้งเตือน", "กลับไปหน้าข้อความ", "เก็บข้อความ");

// Activity Diagrams - Shared (3 pages)
$pages[] = login_logout_page("p20", "Activity: เข้าสู่ระบบ/ออกจากระบบ");
$pages[] = crud("p21", "Activity: อัปเดตโปรไฟล์", "ผู้ใช้งาน (ทุกบทบาท)", "หน้าแรกตามบทบาท", "เลือกเมนูโปรไฟล์", "แก้ไขข้อมูลส่วนตัว&#xa;(ชื่อ/อีเมล/เบอร์โทร)", "หากข้อมูลไม่ถูกต้อง ระบบจะแจ้งเตือน", "อัปเดตสำเร็จ กลับหน้าโปรไฟล์", "อัปเดต&#xa;ข้อมูลโปรไฟล์");
$pages[] = crud("p22", "Activity: เปลี่ยนรหัสผ่าน", "ผู้ใช้งาน (ทุกบทบาท)", "หน้าแรกตามบทบาท", "เลือกเมนูเปลี่ยนรหัสผ่าน", "กรอกรหัสผ่านเดิม&#xa;กรอกรหัสผ่านใหม่ และยืนยัน", "หากรหัสผ่านไม่ถูกต้อง ระบบแจ้งเตือน", "เปลี่ยนรหัสผ่านสำเร็จ กลับหน้าโปรไฟล์", "อัปเดต&#xa;รหัสผ่าน");

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

$filepath = 'diagrams/all_diagrams.drawio';
file_put_contents($filepath, $xml);

echo "✅ สร้างไฟล์สำเร็จ: {$filepath}\n";
echo "📄 จำนวนหน้าทั้งหมด: " . count($pages) . " หน้า\n";
echo "   - Use Case Diagrams: 3 หน้า (ไม่มีสี)\n";
echo "   - Activity Diagrams: 22 หน้า\n";
echo "\n✏️ แก้ไข:\n";
echo "   - Database เป็นกล่องเหลี่ยมมุมโค้ง (rounded rectangle)\n";
echo "   - ไม่ใช้รูปทรงกระบอก (cylinder) แล้ว\n";
