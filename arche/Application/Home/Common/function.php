<?php
//扣分表
    function kfb($sid){
        $deductions = M('deduction')
            ->alias('d')
            ->field([
                's.sid'=>'sid',
                'r.name'=>'rname',
                'r.value'=>'rvalue',
                'd.ctime',
                'd.id',
                'd2.name'=>'class',
                'd1.name'=>'term',
                ])
            ->where(['s.sid'=>$sid])
            ->JOIN('__STUDENT__ s on d.sid=s.sid')
            ->JOIN('__DEDUCTION_RULE__ r on r.id=d.rid')
            ->JOIN('__DICT__ d1 ON d1.field="term" and d1.value=d.term')
            ->JOIN('__DICT__ d2 ON d2.field="class" and d2.value=d.class')
            ->select();
        return $deductions;
    }
    //个学期扣分
    function desum($sid){
        $desum = M('deduction')
            ->alias('d')
            ->field(['sum(r.value)'=>'termsum','sid','d1.name'=>'term'])
            ->JOIN('__DEDUCTION_RULE__ r on d.rid=r.id' )
            ->JOIN('__DICT__ d1 on d1.field="term" and d1.value=d.term' )
            ->group('term,sid')
            ->where(['sid'=>$sid])
            ->select();
            return $desum;
    }

    function ksb($sid){
        //显示考试列表
        $exams = M('exam')
            ->alias('e')
            ->field([
                'e.id',
                'e.sid',
                'er.name',
                'e.score',
                'e.ctime',
                'er.per',
                'round(e.score*er.per/100,2)'=>'result',
                'd1.name'=>'term',
                'd2.name'=>'class'
                ])
            ->JOIN('__EXAM_RULE__ er on er.id=e.name')
            ->JOIN('__DICT__ d1 ON d1.field="term" and d1.value=e.term')
            ->JOIN('__DICT__ d2 ON d2.field="class" and d2.value=e.class')
            ->where(['e.sid'=>$sid])
            ->select();
        return  $exams;
    }

    function examsum($sid){
        $examsum = M('exam')
            ->alias('e')
            ->field([
                'sum(round(e.score*er.per/100,2))'=>'perterm',
                'd1.name'=>'term',
                ])
            ->JOIN('__EXAM_RULE__ er on er.id=e.name')
            ->JOIN('__DICT__ d1 ON d1.field="term" and d1.value=e.term')
            ->where(['e.sid'=>$sid])
            ->group('e.term')
            ->select();
        return $examsum;
    }
    /*
function examsum($sid){
    //各学期考试总分
        $examsum = M('deduction')
            ->alias('d')
            ->field(['sum(r.value)'=>'termsum','sid','d1.name'=>'term'])
            ->JOIN('__DEDUCTION_RULE__ r on d.rid=r.id' )
            ->JOIN('__DICT__ d1 ON d1.field="term" and d1.value=d.term')
            ->group('term,sid')
            ->where(['sid'=>$sid])
            ->select();
            return $examsum;
}
*/
