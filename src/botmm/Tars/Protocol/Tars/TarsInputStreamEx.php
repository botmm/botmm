<?php


namespace botmm\Tars\Protocol\Tars;


class TarsInputStreamExt {

    public static function read($e, int $tag, boolean $isRequire, TarsInputStream $jis) {
        //$info = TarsHelper::getStructInfo($e.getClass());
        //
        //if ($info == null) {
        //    throw new TarsDecodeException("the JavaBean[" + e.getClass().getSimpleName() + "] no annotation Struct");
        //}
        //
        //if ($jis->skipToTag($tag)) {
        //    $hd = new HeadData();
        //            $jis->readHead($hd);
        //            if ($hd->type != TarsStructBase::$STRUCT_BEGIN) {
        //                throw new TarsDecodeException("type mismatch.");
        //            }
        //
        //            $result = CommonUtils::newInstance($e->getClass());
        //
        //            List<TarsStrutPropertyInfo> $list = $info->getPropertyList();
        //            if (!CommonUtils.isEmptyCollection(list)) {
        //                for (TarsStrutPropertyInfo propertyInfo : list) {
        //                    Object value = jis.read(propertyInfo.getStamp(), propertyInfo.getOrder(), propertyInfo.isRequire());
        //                    BeanAccessor.setBeanValue(result, propertyInfo.getName(), value);
        //                }
        //            }
        //            jis.skipToStructEnd();
        //            return result;
        //
        //        } else if (isRequire) {
        //    throw new TarsDecodeException("require field not exist.");
        //}
        //return null;
    }
}
