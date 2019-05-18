function [ s_box,i_s_box ] = SBox()
%UNTITLED6 Summary of this function goes here
%   Detailed explanation goes here
s_box =  magic(16)-1;
X=randperm(numel(s_box));
s_box=reshape(s_box(X),size(s_box));
i_s_box = zeros(16);

   % s_box
for r = 1:16
    for c=1:16
        % get the decimal value from sbox
        sboxdec = (s_box(r,c));
        % sbox value to hex value
        s_box_val = dec2hex(sboxdec);
        % row for inverse matrix
        
        if(sboxdec >=0 && sboxdec < 16)
            i_r = 0;
                    
            i_c = sboxdec;
        else       
            i_r = hex2dec(s_box_val(1));
            % column for inverse value
            i_c = hex2dec(s_box_val(2));
        end
        i_r = i_r + 1;
        i_c = i_c + 1;

        % value to be inserted
        r_in = dec2hex(r-1);
        % value to be inserted
        c_in = dec2hex(c-1);

        
        % value in hex to beinserted at point
        in_sbox_hex = [r_in c_in];
        % value in dec
        in_sbox_value = hex2dec(in_sbox_hex);
       
        i_s_box(i_r,i_c) = in_sbox_value;
        %i_s_box(1,1) = in_sbox_value;\

    end

end

end

