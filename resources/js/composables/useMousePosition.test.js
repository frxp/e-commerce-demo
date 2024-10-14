import { isRef } from "vue";
import { usePriceConversion } from "./usePriceConversion.js";

test("usePriceConversion returns x and y coordinates", () => {
    const { x, y } = usePriceConversion();
    expect(isRef(x)).toBe(true);
    expect(isRef(y)).toBe(true);
    expect(x.value).toBe(0);
    expect(y.value).toBe(0);
});
