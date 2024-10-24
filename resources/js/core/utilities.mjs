function when(condition, trueValue, defaultValue =  null){
    if (condition){
        return is(typeof trueValue, "function") ?
        trueValue() : trueValue;
    }else{
        if (defaultValue){
            return !isNull(defaultValue) && is(typeof defaultValue, "function")
            ? defaultValue() : defaultValue;
        }
        return null;
    }
}
function taskStatusSeverity(status){
    if(status === "WAT")  return "warning";
    if (status === "PRO") return "primary";
    return "success";
}
const isNull = (arg) => arg == null;
const isNullOrWhiteSpace = (arg) => arg == null || arg == "";
const is = (arg, value) => arg == value;

export {
    isNull,
    isNullOrWhiteSpace,
    taskStatusSeverity,
    when,
    is
}

