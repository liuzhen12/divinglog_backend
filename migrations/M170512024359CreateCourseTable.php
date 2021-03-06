<?php

namespace app\migrations;

use app\components\base\BaseMigration;

class M170512024359CreateCourseTable extends BaseMigration
{
    public function safeUp()
    {
        $this->createTable('course', [
            'id' => $this->primaryKey(),
//            'organization' => $this->string(45)->notNull()->defaultValue('')->comment('组织 PADI'),
            'name' => $this->string(100)->notNull()->defaultValue('')->comment('课程组织或名字'),
            'chinese_name' => $this->string(100)->notNull()->defaultValue('')->comment('对应name字段的中文名字'),
            'p_id' => $this->bigInteger()->notNull()->defaultValue(0)->comment('父级id'),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('更新时间戳'),
        ]);
        $this->alterColumn('course',"id","bigint auto_increment");
        $this->createIndex('parent_i',"course",['p_id']);
        $this->batchInsert('course',['id','name','chinese_name','p_id'],[
            [1,"SSI","",0],
            [2,"Scuba Diver Courses","",1],
            [3,"Diver Courses","",2],
            [4,"Scuba Diver","",3],
            [5,"Scuba Rangers","",3],
            [6,"Open Water Diver","",3],
            [7,"Specialty Courses","",2],
            [8,"Perfect Buoyancy","完美浮力",7],
            [9,"Photo & Video","水中摄影与录像",7],
            [10,"Advanced Adventurer","进阶探险潜水员",7],
            [11,"Deep Diving","深潜",7],
            [12,"Navigation","水中导航",7],
            [13,"Search & Recovery","搜索与寻回",7],
            [14,"Night Diving And Limited Visibility","夜潜与低能见度潜水",7],
            [15,"Boat Diving","船潜",7],
            [16,"Dive Guide","潜水导游",7],
            [17,"Scooter / DPV Diving","水中推进器潜水",7],
            [18,"Waves, Tides & Currents","波浪, 潮汐与水流",7],
            [19,"Wreck Diving","沉船潜水",7],
            [20,"Specialty Diver Bundle","潜水专家套餐",7],
            [21,"Advanced Open Water Diver Bundle","进阶开放水域潜水员套餐",7],
            [22,"Master Diver Bundle","潜水大师套餐",7],
            [23,"Dry Suit Diving","干式防寒衣潜水",7],
            [24,"EQUIPMENT TECHNIQUES","装备基础维护",7],
            [25,"Ice Diving","冰潜",7],
            [26,"Independent Diving","独行侠潜水员",7],
            [27,"Recreational Sidemount Diving","休闲侧挂潜水",7],
            [28,"Diver Stress & Rescue","潜水员压力与救援",7],
            [29,"React Right","正确反应员",7],
            [30,"Emergency Training Bundle","紧急应变训练套餐",7],
            [31,"Extended Range Nitrox Diving","扩展等级高氧潜水",7],
            [32,"Caveren Diving","初级洞穴潜水",7],
            [33,"Advanced Wreck Diving","进阶沉船潜水",7],
            [34,"Extended Range Gas Blender","Extended Range GAS Blender",7],
            [35,"Science Of Diving","潜水科学",7],
            [36,"Marine Ecology / Underwater Naturalist","海洋生态学 / 水中自然家",7],
            [37,"Technical Courses","",2],
            [38,"Extended Range Nitrox Diving","扩展等级高氧潜水",37],
            [39,"Caveren Diving","初级洞穴潜水",37],
            [40,"Advanced Wreck Diving","进阶沉船潜水",37],
            [41,"Extended Range Gas Blender","扩展范围气体混合器",37],
            [42,"CCR Hypoxic Trimix","低氧三合一混合气CCR",37],
            [43,"CCR Diving","密闭式循环水肺(CCR)潜水",37],
            [44,"CCR Technical Extended Range","扩展等级CCR技术潜水",37],
            [45,"CCR Extended Range","扩展等级密闭式循环水肺潜水",37],
            [46,"Instructor Courses","",2],
            [47,"Scuba Instructor","",46],
            [48,"Dive Guide","潜水导游",47],
            [49,"Science OF Diving","潜水科学",47],
            [50,"Career STARTER Bundle","事业启动套装课程",47],
            [51,"Divemaster Crossover","潜水长交叉认证",47],
            [52,"Dive Control Specialist","潜水主管",47],
            [53,"Specialty Instructor Package","专长教练套装课程",47],
            [54,"Divemaster Instructor","潜水长教练",47],
            [55,"Instructor Trainer","教练训练官",47],
            [56,"Dive Professional Career Package (DG+DCS/AI+ITC)","潜水专业人士成就套装课程 (潜水导游/潜水主管/助理教练与教练培训课程)",47],
            [57,"Instructor Training Course","教练培训课程",47],
            [58,"Dive Control Specialist Instructor","潜水主管教练",47],
            [59,"Dive Professional Crossover","潜水专业人士交叉认证",47],
            [60,"Technical Instructor","",46],
            [61,"Extended Range (Trimix) Instructor","扩展等级与有限三合一混合气 (开放回路) 教练",60],
            [62,"Technical Extended Range Instructor","技术扩展等级教练",60],
            [63,"Hypoxic Trimix Diving Instructor","低氧三合一混合气教练",60],
            [64,"Caveren Diving Instructor","初级洞穴潜水教练",60],
            [65,"Cave Diving Instructor","中级洞穴潜水教练",60],
            [66,"Full Cave Diving Instructor","高级洞穴潜水教练",60],
            [67,"Advanced Wreck Diving Instructor","进阶沉船潜水教练",60],
            [68,"Technical Wreck Diving Instructor","技术沉船潜水教练",60],
            [69,"Extended Range Nitrox Diving Instructor","扩展等级高氧教练",60],
            [70,"Crossover","",46],
            [71,"Divemaster Crossover","潜水长交叉认证",70],
            [72,"Dive Professional Crossover","潜水专业人士交叉认证",70],
            [73,"FreeDiver Courses","",1],
            [74,"Diver Courses","",73],
            [75,"Try Freediving","体验自由潜水",74],
            [76,"Basic Freediving","基础自由潜水",74],
            [77,"Freediving Level 1","LEVEL 1 自由潜水",74],
            [78,"Scooter / DPV Diving","水中推进器潜水",74],
            [79,"React Right","正确反应员",74],
            [80,"Instructor Courses","",73],
            [81,"FreeDiving Basic Pool & Level 1 Instructor","基础自由潜水, 泳池自由潜水, LEVEL 1 自由潜水教练",80],
            [82,"FreeDiving Level 2 Instructor","LEVEL 2 自由潜水教练",80],
            [83,"FreeDiving Level 3 Instructor","LEVEL 3 自由潜水教练",80],
            [84,"FreeDiving Level 3 Instructor","自由潜水教练交叉认证",80],
            [85,"Snorkeling Courses","",1],
            [86,"Diver Courses","",85],
            [87,"Snorkeling (FOC)","浮潜课程 (免费)",86],
            [88,"Instructor Courses","",85],
            [89,"Snorkeling Instructor","浮潜教练",88],
            [1000,"PADI","",0],
            [1002,"Scuba Diver Courses","",1000],
            [1003,"Diver Courses","",1002],
            [1004,"Open Water Diver","开放水域潜水员",1003],
            [1005,"Adventure Diver","探险潜水员",1003],
            [1006,"Advanced Open Water Diver","进阶开放水域潜水员",1003],
            [1007,"Rescue Diver","营救潜水员",1003],
            [1008,"Master Scuba Diver","名仕潜水员",1003],
            [1009,"Specialty Courses","",1002],
            [1010,"Advanced Rebreather Diver","",1009],
            [1011,"Altitude Diver","高海拔潜水员",1009],
            [1012,"AWARE - Fish Identification","AWARE - 鱼类辨识",1009],
            [1013,"Boat Diver","船潜潜水员",1009],
            [1014,"Cavern Diver","船潜潜水员",1009],
            [1015,"Deep Diver","深潜潜水员",1009],
            [1016,"Digital Underwater Photographer","数码水底摄影师",1009],
            [1017,"Diver Propulsion Vehicle Diver","水中推进器潜水员",1009],
            [1018,"Discover Rebreather","",1009],
            [1019,"Drift Diver","放流潜水员",1009],
            [1020,"Dry Suit Diver","干式潜水衣潜水员",1009],
            [1021,"Enriched Air Diver","高氧空气元水源",1009],
            [1022,"Emergency Oxygen Provider","紧急供氧",1009],
            [1023,"Equipment Specialist","装备专家",1009],
            [1024,"Ice Diver","冰潜潜水员",1009],
            [1025,"Multilevel Diver","多层深度潜水员",1009],
            [1026,"Night Diver","夜潜潜水员",1009],
            [1027,"Peak Performance Buoyancy","顶尖中性浮力",1009],
            [1028,"Rebreather Diver","",1009],
            [1029,"Public Safety Diver™","",1009],
            [1030,"Search and Recovery Diver","搜索与寻回潜水员",1009],
            [1031,"Sidemount Diver","侧挂气瓶潜水员",1009],
            [1032,"Underwater Naturalist","水中自然观察家",1009],
            [1033,"Underwater Navigator","水底导航",1009],
            [1034,"Underwater Videographer","水底录像",1009],
            [1035,"Wreck Diver","沉船潜水员",1009],
            [1036,"Distinctive Specialties","",1009],
            [1037,"Technical Courses","",1002],
            [1038,"Tec","",1037],
            [1039,"Discover Tec Diving","",1038],
            [1040,"Tec 40","",1038],
            [1041,"Tec 45","",1038],
            [1042,"Tec 50","",1038],
            [1043,"Tec Trimix 65","",1038],
            [1044,"Tec Trimix Diver","",1038],
            [1045,"Tec Gas Blender","",1038],
            [1046,"Tec 40 CCR","",1038],
            [1047,"Tec 60 CCR","",1038],
            [1048,"Tec 100 CCR","",1038],
            [1049,"Tec Sidemount","",1038],
            [1050,"Instructor Courses","",1002],
            [1051,"Divemaster","潜水长",1050],
            [1052,"Assistant Instructor","助理教练",1050],
            [1053,"Scuba Instructor","",1050],
            [1054,"Open Water Scuba Instructor","",1053],
            [1055,"Specialty Instructor","",1053],
            [1056,"Master Scuba Diver Trainer","",1053],
            [1057,"Master Instructor Rating","",1053],
            [1058,"Technical Instructor","",1050],
            [1059,"Tec Instructor","",1058],
            [1060,"Tec Deep Instructor","",1058],
            [1061,"Tec Gas Blender Instructor","",1058],
            [1062,"Tec Trimix Instructor","",1058],
            [1063,"Tec Sidemount Instructor","",1058],
            [1064,"Tec 40 CCR Instructor","",1058],
            [1065,"Tec 60 CCR Instructor","",1058],
            [1066,"Tec 100 CCR Instructor","",1058],
            [1067,"Professional Instructor","",1050],
            [1068,"IDC Staff Instructor","",1067],
            [1069,"Course Director","",1067],
            [1070,"CPR and First Aid Instructor","",1050],
            [1071,"Emergency First Response Instructor","",1070],
            [1072,"Youth Courses","",1000],
            [1073,"Diver Courses","",1072],
            [1074,"Discover Scuba® Diving (10 yrs+)","",1073],
            [1075,"Bubblemaker (8 yrs+)","",1073],
            [1076,"PADI Seal Team (8 yrs+)","",1073],
            [1077,"PADI Skin Diver","",1073],
            [1078,"Specialty Courses","",1072],
            [1079,"AWARE - Coral Reef Conservation Diver","",1078],
            [1080,"Project AWARE® Specialist","",1078],
            [1081,"Freediver Courses","",1000],
            [1082,"Diver Courses","",1081],
            [1083,"Basic Freediver","",1082],
            [1084,"Freediver","",1082],
            [1085,"Advanced Freediver","",1082],
            [1086,"Master Freediver","",1082],
            [1087,"Instructor Courses","",1081],
            [1088,"Freediver Instructor","",1087],
            [1089,"Advanced Freediver Instructor","",1087],
            [1090,"Master Freediver Instructor","",1087],
            [1091,"Freediver Instructor Trainer","",1087],
            [2000,"NAUI","",0],
            [2001,"Scuba Diver Courses","",2000],
            [2002,"Diver Courses","",2001],
            [2003,"Get Certified- Scuba Diver","",2002],
            [2004,"Enriched Air Nitrox (EANx) Diver","",2002],
            [2005,"Advanced Scuba Diver","",2002],
            [2006,"Rescue Scuba Diver","",2002],
            [2007,"Master Scuba Diver","",2002],
            [2008,"First Aid Provider","",2002],
            [2009,"Specialty Courses","",2001],
            [2010,"Night Diver","",2009],
            [2011,"Deep Diver","",2009],
            [2012,"Underwater Photographer","",2009],
            [2013,"Underwater Videographer","",2009],
            [2014,"Training Assistant","",2009],
            [2015,"Public Safety Diver","",2009],
            [2016,"Technical Courses","",2001],
            [2017,"Introduction to Technical Diving Skills","",2016],
            [2018,"Sidemount Diver","",2017],
            [2019,"Mixed Gas and Decompression Diving","",2016],
            [2020,"Technical Decompression Diver","",2019],
            [2021,"Helitrox Diver","",2019],
            [2022,"Trimix Diver","",2019],
            [2023,"Extreme Exposure Diver","",2019],
            [2024,"Technical Support Leader","",2019],
            [2025,"Rebreather Diving","",2016],
            [2026,"Semi-Closed Rebreather","",2025],
            [2027,"CCR Diver","",2025],
            [2028,"CCR Mixed Gas Diver","",2025],
            [2029,"Extreme Exposure CCR Mixed Gas Diver","",2025],
            [2030,"Overhead Environments","",2016],
            [2031,"Cavern Diver","",2030],
            [2032,"Cave Diver (Levels I and II)","",2030],
            [2033,"Cave Guide","",2030],
            [2034,"Wreck Penetration Diver","",2030],
            [2035,"Technical Wreck Penetration Diver","",2030],
            [2036,"Technical Ice Diver","",2030],
            [2037,"Mine Diver (Levels I and II)","",2030],
            [2038,"Diver Propulsion Vehicle (DPV)","",2016],
            [2039,"DPV Technical Diver","",2038],
            [2040,"DPV Extreme Exposure Diver","",2038],
            [2041,"Gas Blender and O2 Service Technician","",2016],
            [2042,"Nitrox Gas Blender and O2 Tech","",2041],
            [2043,"Mixed Gas Blender and O2 Tech","",2041],
            [2044,"Instructor Courses","",2001],
            [2045,"NAUI FIT","",2044],
            [2046,"Skin Diving Instructor","",2044],
            [2047,"Assistant Instructor","",2044],
            [2048,"Divemaster","",2044],
            [2049,"Instructor","",2044],
            [2050,"Instructor Crossover","",2044],
            [2051,"Instructor Trainer","",2044],
            [2052,"Course Director","",2044],
            [2053,"Freediver Courses","",2000],
            [2054,"Snorkeler","",2053],
            [2055,"Safe Buddy","",2053],
            [2056,"Free Diver","",2053],
            [2057,"Intermediate Freediver","",2053],
            [2058,"Advanced Freediver","",2053],
            [2059,"Freediving Specialties","",2053],
            [3000,"CMAS","",0],
            [3001,"Scuba Diver Courses","",3000],
            [3002,"Diver*","",3001],
            [3003,"Dry Suit Diver","",3002],
            [3004,"Nitrox Diver","",3002],
            [3005,"Semi - Closed Circuit Rebreather Diver","",3002],
            [3006,"Closed Circuit Rebreather Diver","",3002],
            [3007,"Diver**","",3001],
            [3008,"Extended Range Diver","",3007],
            [3009,"Advanced Nitrox Diver","",3007],
            [3010,"Scooter Diver Level 1 (Recreational Scooter Diver)","",3007],
            [3011,"Scooter Diver Level 2, (Tec Scooter Diver)","",3007],
            [3012,"Cave Diver 1, Cavern Diver","",3007],
            [3013,"Cave Diver 2, Cave Diver","",3007],
            [3014,"Ice Diver","",3007],
            [3015,"Diver***","",3001],
            [3016,"Diver*** Children Diving ","",3015],
            [3017,"Normoxic Trimix Diver","",3015],
            [3018,"Advenced Trimix Diver","",3015],
            [3019,"Scooter Diver Level 3, (Overhead Environment)","",3015],
            [3020,"Cave Diver 3, Full Cave Diver","",3015],
            [3021,"Diver****","",3001],
            [3022,"Instructor*","",3001],
            [3023,"Children Diving Training Instructor","",3022],
            [3024,"Children Diving Instructor Trainer","",3022],
            [3025,"Nitrox Instructor","",3022],
            [3026,"Advanced Semi - Closed Circuit Rebreather Diver","",3022],
            [3027,"Closed Circuit Rebreather Instructor","",3022],
            [3028,"Nitrox Gasblender","",3022],
            [3029,"Trimix Gasblender","",3022],
            [3030,"Trimix Gasblender Instructor","",3022],
            [3031,"Nitrox Gasblender Instructor","",3022],
            [3032,"Cave Diving Instructor 1, Cavern Diving Instructor","",3022],
            [3033,"Ice Diving Instructor","",3022],
            [3034,"Instructor**","",3001],
            [3035,"Extended Range Instructor","",3034],
            [3036,"Advanced Nitrox Instructor","",3034],
            [3037,"Semi - Closed Circuit Rebreather Instructor","",3034],
            [3038,"Advanced Semi - Closed Circuit Rebreather Instructor","",3034],
            [3039,"Normoxic Trimix Instructor","",3034],
            [3040,"Advanced Trimix Instructor","",3034],
            [3041,"Scooter Instructor Level 1","",3034],
            [3042,"Scooter Instructor Level 2","",3034],
            [3043,"Scooter Instructor Level 3","",3034],
            [3044,"Cave Diving Instructor 2, Full Cave Diving Instructor","",3034],
            [3045,"Instructor***","",3001],
            [3046,"Advanced Trimix Instructor Trainer","",3045],
            [3047,"Cave Diving Instructor 3, Cave Diving Staff Instructor","",3045]
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('course');
    }
}
