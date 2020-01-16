<?php


namespace botmm\Tars\Protocol\Tars;


class TarsOutputStreamEx
{
    /**
     * @param object           $e
     * @param int              $tag
     * @param TarsOutputStream $jos
     */
    public static function write($e, int $tag, TarsOutputStream $jos) {
        //TarsStructInfo info = TarsHelper.getStructInfo(e.getClass());
        //if (info == null) {
        //    throw new TarsEncodeException("the JavaBean[" + e.getClass().getSimpleName() + "] no annotation Struct");
        //}
        //
        //jos.reserve(2);
        //jos.writeHead(TarsStructBase.STRUCT_BEGIN, tag);
        //List<TarsStrutPropertyInfo> propertysList = info.getPropertyList();
        //if (!CommonUtils.isEmptyCollection(propertysList)) {
        //    for (TarsStrutPropertyInfo propertyInfo : propertysList) {
        //        Object value = null;
        //        try {
        //            value = BeanAccessor.getBeanValue(e, propertyInfo.getName());
        //        } catch (Exception ex) {
        //            throw new TarsEncodeException(ex.getLocalizedMessage());
        //        }
        //
        //        if (value == null && propertyInfo.isRequire()) {
        //            throw new TarsEncodeException(propertyInfo.getName() + " is require tag=" + propertyInfo.getOrder());
        //        }
        //
        //        if (value != null) {
        //            jos.write(value, propertyInfo.getOrder());
        //        }
        //    }
        //}
        //
        //jos.reserve(2);
        //jos.writeHead(TarsStructBase.STRUCT_END, 0);
    }
}